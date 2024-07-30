<?php

namespace App\Integrations\OneID\Classes;
use App\Integrations\Base\Exceptions\{ClientError,
    ConnectionException,
    ServerException,
    TimeoutException,
    UnknownError};
use App\Integrations\OneID\Responses\{OneIDAccessTokenResponse, OneIDUserResponse};
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
     * @param string $code
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
        $data = $this->client->sendPost('', [
            'query' => [
                'grant_type' => 'one_authorization_code',
                'client_id' => $this->client->client_id,
                'client_secret' => $this->client->client_secret,
                'redirect_uri' => config('integrations.oneID.redirect_uri'),
                'code' => $code
            ]
        ]);
        if (isset($data['access_token'], $data['scope']) && $data['scope'] == config('integrations.oneID.scope')) {
            $accessToken = new OneIDAccessTokenResponse($data);
            return [
                'scope' => $accessToken->scope,
                'refresh_token' => $accessToken->refresh_token,
                'expires_in' => $accessToken->expires_in,
                'access_token' => $accessToken->getAccessToken(),
            ];
        }
        return false;
    }

    /**
     * @param string $access_token
     *
     * @throws ClientError
     * @throws ConnectionException
     * @throws ServerException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getUserData(string $access_token): array|bool
    {
        $data = $this->client->sendPost('', [
            'query' => [
                'grant_type' => 'one_access_token_identify',
                'client_id' => $this->client->client_id,
                'client_secret' => $this->client->client_secret,
                'access_token' => $access_token,
                'scope' => config('integrations.oneID.scope')
            ]
        ]);
        if (isset($data['pin'], $data['auth_method'])) {
            $userData = new OneIDUserResponse($data);
            return [
                'pin' => $userData->getPin(),
                'passport' => $userData->getPassport(),
                'f_name' => $userData->first_name,
                'l_name' => $userData->sur_name,
                's_name' => $userData->mid_name,
                'username' => $userData->user_id,
                'gender' => $userData->gender(),
                'isJuridic' => $userData->isJuridic(),
                'tin' => $userData->getLegalTin(),
                'legalInfo' => $userData->getLegalInfo(),
                'data' => $data
            ];
        }
        return false;
    }


}
