<?php

namespace App\Integrations\OneID\Utils;


use App\Models\V1\AuthLog;
use App\Integrations\OneID\Exceptions\{OneIDTimeoutException, OneIDServerException, OneIDConnectionException, OneIDClientError, OneIDUnknownError};
use Exception;
use App\Integrations\Base\Utils\Client;
use GuzzleHttp\Exception\{ClientException,ServerException, ConnectException };
use JetBrains\PhpStorm\Pure;

class OneIDClient extends Client
{
    public string $client_id;
    public string $client_secret;
    #[Pure] public function __construct(string $url, string $client_id, string $client_secret)
    {
        parent::__construct($url, 'auth', 'oneID');
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    public function sendPost(string $url, array $options = []): array
    {
        try {
            return parent::sendPost($url, $options);
        }
        catch (Exception $exception) {
            if(isset($options['json'])){
                $options['url'] = $url;
                $this->writeAuthLog([
                    'system' => 'oneID',
                    'request' => $options,
                    'response' => ['error' => $exception->getMessage()],
                    'error_code' => $exception->getCode()
                ]);
            }
            throw $exception;
        }
    }

    public function sendGet(string $url, array $options = []): array
    {
        try {
            return parent::sendGet($url, $options);
        }
        catch (Exception $exception) {
            if(isset($options['json'])){
                $options['url'] = $url;
                $this->writeAuthLog([
                    'system' => 'oneID',
                    'request' => $options,
                    'response' => ['error' => $exception->getMessage()],
                    'error_code' => $exception->getCode()
                ]);
            }
            throw $exception;
        }
    }

    /**
     * @throws OneIDTimeoutException
     */
    protected function throwTimeoutException(ConnectException $exception): void
    {
        throw new OneIDTimeoutException('OneID_TIMEOUT_EXCEPTION');
    }

    /**
     * @return void
     * @throws OneIDClientError
     */
    protected function throwClientException(ClientException $exception): void
    {
        throw new OneIDClientError($exception->getResponse()->getBody()->getContents(), $exception->getCode());
    }

    /**
     * @return void
     * @throws OneIDServerException
     */
    protected function throwServerException(ServerException $exception): void
    {
        throw new OneIDServerException($exception->getMessage(), $exception->getCode());
    }

    /**
     * @return void
     * @throws OneIDConnectionException
     */
    protected function throwConnectionException(ConnectException $exception): void
    {
        throw new OneIDConnectionException('OneID_CONNECTION_TIMEOUT_ERROR');
    }



    /**
     * @return void
     * @throws OneIDUnknownError
     */
    protected function throwUnknownException(Exception $exception): void
    {
        throw  new OneIDUnknownError('OneID_UNKNOWN_ERROR');
    }


    private function writeAuthLog($data): void
    {
        try {
            AuthLog::query()->create($data);
        } catch (Exception $exception) {
            info('couldn\'t write auth log', [$exception->getMessage()]);
        }
    }
}
