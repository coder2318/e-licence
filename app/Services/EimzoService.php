<?php

namespace App\Services;

use App\Integrations\Base\Exceptions\ClientError;
use App\Integrations\Base\Exceptions\ConnectionException;
use App\Integrations\Base\Exceptions\ServerException;
use App\Integrations\Base\Exceptions\TimeoutException;
use App\Integrations\Base\Exceptions\UnknownError;
use App\Integrations\Eimzo\Eimzo;
use App\Models\User;
use App\Traits\AssignRoleTrait;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class EimzoService
{
    use AssignRoleTrait;
    protected string $baseUrl;
    protected string $eimzoAuthUrl;

    public function __construct()
    {
        $this->baseUrl = config('integrations.eimzo.base_url');
        $this->eimzoAuthUrl = config('integrations.eimzo.auth_url');;
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
    public function challenge()
    {
        $params = ['_uc' => time() . "_" . mt_rand()];
        $eimzoClient = new Eimzo();
        $res = $eimzoClient->userData()->getChallenge($params);
        if($res)
            return ['challenge' => $res['challenge']];
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
    public function auth($request)
    {
        $user_ip = $request->header('X-Real-IP', $request->ip());
        $host = $request->getHost();

        $headers = [
            'Host' => $host,
            'X-Real-IP' => $user_ip,
        ];

        $pkcs7 = $request->input('pkcs7');
        $keyId = $request->input('keyId');
        $ch = curl_init();
        $url = $this->baseUrl.$this->eimzoAuthUrl;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pkcs7);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $body = curl_getinfo($ch);
        info('body', [$body]);
        curl_close($ch);
        info('res', [$response]);
        if ($httpcode == 200) {
            $jr = json_decode($response, true);
            if ($jr['status'] != 1) {
                return [
                    'status' => $jr['status'],
                    'message' => addslashes($jr['message']),
                ];
            } else {
                Session::put('USER_INFO', json_encode($jr['subjectCertificateInfo']));
                Log::warning($jr['subjectCertificateInfo']);
                Session::put('KEY_ID', $keyId);

                $subjectInfo = $jr['subjectCertificateInfo'];
                $pinfl = $subjectInfo['subjectName']['1.2.860.3.16.1.2'];


                // Check if the user already exists
                $user = User::where('pin', $pinfl)->first();

                if (!$user) {
                    // Register a new user
                    $user = new User();
                    $user->f_name = $subjectInfo['subjectName']['Name'];
                    $user->l_name = $subjectInfo['subjectName']['SURNAME'];
                    $user->pin = $pinfl;
                    $user->password = $pinfl;
                    $user->passport = substr($pinfl, 0, 9);
                    // Add other user details as necessary
                    $user->save();

                    // Log the new user in

                }
                Auth::login($user);
                $this->getRole($user, User::ROLE_USER);
                return [
                    'status' => 1,
                    'redirect' => route('application.index'),
                ];
            }
        }

//        $eimzoClient = new Eimzo();
//        $res = $eimzoClient->userData()->getUserData($request);
//        if($res)
//            return $res;
//        return false;


    }

    public function checkRegister($params): User|Model
    {
        return User::query()->updateOrCreate([
            'pin' => $params['pin'],
        ], [
            'username' => $params['username'],
            'password' => $params['pin'],
            'f_name' => $params['f_name'],
            'l_name' => $params['l_name'],
            'tin' => $params['tin'],
            'data' => $params['data']
        ]);
    }
}
