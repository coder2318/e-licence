<?php

namespace App\Integrations\Base\Utils;


use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as ClientGuzzle;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use App\Integrations\Base\Exceptions\ClientError;
use App\Integrations\Base\Exceptions\UnknownError;
use App\Integrations\Base\Exceptions\TimeoutException;
use App\Integrations\Base\Exceptions\ConnectionException;
use App\Integrations\Base\Exceptions\ServerException as BaseServerException;

class Client
{
    /**
     * @var string
     */
    protected string $base_url;

    protected ?ClientGuzzle $client = null;
    protected string $system;
    protected string $system_type;
    private array $options;

    /**
     * @return ClientGuzzle
     */
    public function getClient(): ClientGuzzle
    {
        if (!$this->client) {
            $options = array_merge_recursive([
                'timeout'            => 10,
                'connection_timeout' => 5,
                'headers'            => [
                    'Language' => app()->getLocale(),
                ],
            ], $this->options);

            $this->client = new ClientGuzzle($options);
        }

        return $this->client;
    }

    /**
     * @param ClientGuzzle|null $client
     */
    public function setClient(?ClientGuzzle $client): void
    {
        $this->client = $client;
    }

    public function __construct(string $url, string $system, string $system_type, array $options = [])
    {
        $this->base_url = $url && str_ends_with($url, '/')
            ? substr($url, 0, -1)
            : $url;

        $this->system = $system;
        $this->system_type = $system_type;
        $this->options = $options;
    }

    public function getSystem(): string
    {
        return $this->system;
    }

    public function getSystemType(): string
    {
        return $this->system_type;
    }


    /**
     * @param string $method
     * @param string $url
     * @param array  $options
     *
     * @return array
     * @throws BaseServerException
     * @throws ClientError
     * @throws ConnectionException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws GuzzleException|JsonException
     */
    public function sendRequest(string $method, string $url, array $options = []): array
    {
        $id = Uuid::uuid4();
        try {
            $base_url = $this->base_url ? $this->base_url . '/' : '';
            $requestOptions = $options;
            $requestOptions['url'] = $url;
            $this->log('info', [
                'type'       => 'REQUEST',
                'system'      => $this->system,
                'system_type' => $this->system_type,
                'message'     => $requestOptions,
                'request_id'  => $id,
            ]);
            $res = $this->getClient()->request($method, $base_url . $url, $options);
            $res_content = $res->getBody()->getContents();
            $this->log('info', [
                'type'       => 'RESPONSE',
                'system'      => $this->system,
                'system_type' => $this->system_type,
                'message'     => $res_content,
                'request_id'  => $id,
            ]);

            return json_decode($res_content, 1, 512, JSON_THROW_ON_ERROR);
        } catch (ConnectException $exception) {
            if (method_exists($exception, 'getHandlerContext')) {
                $errno = $exception->getHandlerContext()['errno'] ?? 0;
                if ($errno === 28) {
                    $this->throwTimeoutException($exception);
                }
            }
            $this->log('alert', [
                'type'       => 'CONNECTION_TIMEOUT',
                'system'      => $this->system,
                'system_type' => $this->system_type,
                'message'     => $exception->getMessage(),
                'request_id'  => $id,
            ]);
            $this->throwConnectionException($exception);
        } catch (ClientException $exception) {

            $this->log('error', [
                'type'       => 'CLIENT_ERROR',
                'system'      => $this->system,
                'system_type' => $this->system_type,
                'message'     => $exception->getMessage(),
                'request_id'  => $id,
            ]);


            $this->throwClientException($exception);
        } catch (ServerException $exception) {
            $this->log('error', [
                'type'       => 'SERVER_ERROR',
                'system'      => $this->system,
                'system_type' => $this->system_type,
                'message'     => $exception->getMessage(),
                'request_id'  => $id,
            ]);

            $this->throwServerException($exception);
        } catch (Exception $exception) {
            $this->log('error', [
                'type'       => 'UNKNOWN_ERROR',
                'system'      => $this->system,
                'system_type' => $this->system_type,
                'message'     => $exception->getMessage(),
                'request_id'  => $id,
            ]);

            $this->throwUnknownException($exception);
        }
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return array
     * @throws BaseServerException
     * @throws ClientError
     * @throws ConnectionException
     * @throws JsonException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws GuzzleException
     */
    public function sendPost(string $url, array $options = []): array
    {
        return $this->sendRequest('POST', $url, $options);
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return array
     * @throws BaseServerException
     * @throws ClientError
     * @throws ConnectionException
     * @throws JsonException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws GuzzleException
     */
    public function sendGet(string $url, array $options = []): array
    {
        return $this->sendRequest('GET', $url, $options);
    }

    /**
     * @throws TimeoutException
     */
    protected function throwTimeoutException(ConnectException $exception): void
    {
        throw new TimeoutException('TIMEOUT_EXCEPTION', 424);
    }

    /**
     * @return void
     * @throws BaseServerException
     */
    protected function throwServerException(ServerException $exception): void
    {
        throw new BaseServerException('SERVER_EXCEPTION', $exception->getCode());
    }

    /**
     * @return void
     * @throws ConnectionException
     */
    protected function throwConnectionException(ConnectException $exception): void
    {
        throw new ConnectionException('CONNECTION_TIMEOUT', $exception->getCode());
    }

    /**
     * @return void
     * @throws ClientError
     */
    protected function throwClientException(ClientException $exception): void
    {
        throw new ClientError($exception->getMessage(), 400);
    }

    /**
     * @return void
     * @throws UnknownError
     */
    protected function throwUnknownException(Exception $exception): void
    {
        throw  new UnknownError('UNKNOWN_ERROR', 500);
    }


    /**
     * @param string $level
     * @param array  $array
     * @param array  $context
     *
     * @return void
     * @throws JsonException
     */
    protected function log(string $level, array $array = [], array $context = []): void
    {
        Log::channel('stack')->log($level, json_encode($array, JSON_THROW_ON_ERROR), $context);
    }

}
