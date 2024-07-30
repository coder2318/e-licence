<?php

namespace App\Services;

use App\Integrations\Base\Exceptions\ClientError;
use App\Integrations\Base\Exceptions\ConnectionException;
use App\Integrations\Base\Exceptions\ServerException;
use App\Integrations\Base\Exceptions\TimeoutException;
use App\Integrations\Base\Exceptions\UnknownError;
use App\Integrations\OneID\OneID;
use App\Integrations\OneID\Utils\OneIDClient;
use App\Models\User;
use App\Traits\AssignRoleTrait;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OneIdService
{
    use AssignRoleTrait;
    public function checkRegister($params): User|Model
    {
        return User::query()->updateOrCreate([
            'pin' => $params['pin'],
        ], [
            'passport' => $params['passport'],
            'username' => $params['username'],
            'password' => $params['pin'],
            'f_name' => $params['f_name'],
            'l_name' => $params['l_name'],
            's_name' => $params['s_name'],
            'tin' => $params['tin'],
            'data' => $params['data']
        ]);
    }

    /**
     * @throws ConnectionException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws \JsonException
     * @throws ClientError
     * @throws ServerException
     * @throws GuzzleException
     */
    public function userData($params): bool|array
    {
        $accessToken = $this->sendGetToken($params['code']);
        if($accessToken){
            $userData = $this->getUserData($accessToken);
            if($userData)
                return $userData;
            return false;
        }
        return false;
    }

    /**
     * @throws ConnectionException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws \JsonException
     * @throws ClientError
     * @throws ServerException
     * @throws GuzzleException
     */
    public function sendGetToken($code): bool|string
    {
        $oneIdClient = new OneID();
        $getAccessToken = $oneIdClient->userData()->getAccessToken($code);
        if($getAccessToken){
            return $getAccessToken['access_token'];
        }
        return false;
    }

    /**
     * @throws ConnectionException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws \JsonException
     * @throws ClientError
     * @throws ServerException
     * @throws GuzzleException
     */
    public function getUserData($accessToken): bool|array
    {
        $oneIdClient = new OneID();
        $userData = $oneIdClient->userData()->getUserData($accessToken);
        if($userData)
            return $userData;
        return false;
    }

}
