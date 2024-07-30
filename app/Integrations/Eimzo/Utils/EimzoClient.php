<?php

namespace App\Integrations\Eimzo\Utils;


use App\Models\V1\AuthLog;
use App\Integrations\Eimzo\Exceptions\{EimzoTimeoutException, EimzoServerException, EimzoConnectionException, EimzoClientError, EimzoUnknownError};
use Exception;
use App\Integrations\Base\Utils\Client;
use GuzzleHttp\Exception\{ClientException,ServerException, ConnectException };
use JetBrains\PhpStorm\Pure;

class EimzoClient extends Client
{
    public string $challengeUrl;
    public string $authUrl;

    #[Pure] public function __construct(string $baseUrl, string $challengeUrl, string $authUrl)
    {
        parent::__construct($baseUrl, 'auth', 'Eimzo');
        $this->challengeUrl = $challengeUrl;
        $this->authUrl = $authUrl;
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
                    'system' => 'Eimzo',
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
                    'system' => 'Eimzo',
                    'request' => $options,
                    'response' => ['error' => $exception->getMessage()],
                    'error_code' => $exception->getCode()
                ]);
            }
            throw $exception;
        }
    }

    /**
     * @throws EimzoTimeoutException
     */
    protected function throwTimeoutException(ConnectException $exception): void
    {
        throw new EimzoTimeoutException('OneID_TIMEOUT_EXCEPTION');
    }

    /**
     * @return void
     * @throws EimzoClientError
     */
    protected function throwClientException(ClientException $exception): void
    {
        throw new EimzoClientError($exception->getResponse()->getBody()->getContents(), $exception->getCode());
    }

    /**
     * @return void
     * @throws EimzoServerException
     */
    protected function throwServerException(ServerException $exception): void
    {
        throw new EimzoServerException($exception->getMessage(), $exception->getCode());
    }

    /**
     * @return void
     * @throws EimzoConnectionException
     */
    protected function throwConnectionException(ConnectException $exception): void
    {
        throw new EimzoConnectionException('OneID_CONNECTION_TIMEOUT_ERROR');
    }



    /**
     * @return void
     * @throws EimzoUnknownError
     */
    protected function throwUnknownException(Exception $exception): void
    {
        throw  new EimzoUnknownError('OneID_UNKNOWN_ERROR');
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
