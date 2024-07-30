<?php

namespace App\Integrations\Eimzo\Classes;
use App\Integrations\Base\Exceptions\{ClientError,
    ConnectionException,
    ServerException,
    TimeoutException,
    UnknownError};
use App\Integrations\Eimzo\Responses\{EimzoChallengeResponse, EimzoUserResponse};
use App\Integrations\Eimzo\Utils\EimzoClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use JsonException;

class UserData
{
    private ?EimzoClient $client;

    public function __construct(EimzoClient $client = null)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return array|bool
     * @throws ClientError
     * @throws ConnectionException
     * @throws GuzzleException
     * @throws JsonException
     * @throws ServerException
     * @throws TimeoutException
     * @throws UnknownError
     */
    public function getChallenge(array $params): array|bool
    {
        $data = $this->client->sendGet($this->client->challengeUrl, [
            'query' => $params
        ]);
        if (isset($data['status'], $data['challenge']) && $data['status'] == 1) {
            $eimzoChallenge = new EimzoChallengeResponse($data);
            return [
                'challenge' => $eimzoChallenge->getChallenge(),
                'status' => $eimzoChallenge->status,
                'message' => $eimzoChallenge->getMessage(),
            ];
        }
        return false;
    }

    /**
     * @param Request $request
     * @return array|bool
     * @throws ClientError
     * @throws ConnectionException
     * @throws GuzzleException
     * @throws JsonException
     * @throws ServerException
     * @throws TimeoutException
     * @throws UnknownError
     */
    public function getUserData(Request $request): array|bool
    {
        $user_ip = $request->header('X-Real-IP', $request->ip());
        $host = $request->getHost();

        $headers = [
            'Host' => $host,
            'X-Real-IP' => $user_ip,
        ];

        $pkcs7 = $request->input('pkcs7');
        $keyId = $request->input('keyId');
        $data = $this->client->sendPost($this->client->authUrl, [
            'headers' => $headers,
            'form_params' => [$pkcs7],
        ]);
        if (isset($data['status'], $data['subjectCertificateInfo']) && $data['status'] == 1) {

            Session::put('USER_INFO', json_encode($data['subjectCertificateInfo']));
            Session::put('KEY_ID', $keyId);

            $userData = new EimzoUserResponse($data['subjectCertificateInfo']);
            return [
                'pin' => $userData->getPin(),
                'f_name' => $userData->getFName(),
                'l_name' => $userData->getLName(),
                'username' => $userData->getTin(),
                'tin' => $userData->getTin(),
                'data' => $data
            ];
        }
        return false;
    }


}
