<?php

namespace App\Integrations\OneID\Classes;

use App\Integrations\Base\Exceptions\ClientError;
use App\Integrations\Base\Exceptions\ConnectionException;
use App\Integrations\Base\Exceptions\ServerException;
use App\Integrations\Base\Exceptions\TimeoutException;
use App\Integrations\Base\Exceptions\UnknownError;
use App\Integrations\OneID\Responses\OneIDUserResponse;
use App\Integrations\OneID\Utils\OneIDClient;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class UserData
{
    private ?OneIDClient $client;

    public function __construct(OneIDClient $client = null)
    {
        $this->client = $client;
    }

    /**
     * @param string $document_id
     *
     * @throws ClientError
     * @throws ConnectionException
     * @throws ServerException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getAccessToken(string $code): array|bool
    {
        $data = $this->client->sendGet('', [
            'query' => [
                'grant_type' => 'one_authorization_code',
                'client_id' => $this->client->client_id,
                'client_secret' => $this->client->client_secret,
                'redirect_uri' => config('integrations.oneID.redirect_uri'),
                'code' => $code
            ]
        ]);
        if (isset($data['access_token'], $data['scope']) && $data['scope'] == config('integrations.oneID.scope')) {
            $document = new OneIDUserResponse($data['body']['OneID']);
            return [
                'id' => $document->id,
                'create_time' => $document->create_time,
                'name' => $document->name,
                'versions' => $document->getVersions()
            ];
        }
        return false;
    }

    /**
     * @param array $params
     *
     * @throws ClientError
     * @throws ConnectionException
     * @throws ServerException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws GuzzleException
     * @throws JsonException
     */
    public function createContract(array $params): array|bool
    {
        $data = $this->client->sendPost('core/hook/on/ordering', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->client->token
            ],
            'json' => $params
        ]);
        if ($data['success'] && isset($data['body']['document']['contract'])) {
            $document = new OneIDUserResponse($data['body']['document']['contract']);
            return [
                'id' => $document->id,
                'date' => $document->date,
                'name' => $document->name,
                'serialNumber' => $document->serialNumber
            ];
        }
        return false;
    }


}
