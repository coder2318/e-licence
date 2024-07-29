<?php

namespace App\Http\Controllers\V1;

use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Services\OneIdService;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OneIdController extends AuthController implements AuthInterface
{
    protected string $url;

    public function __construct(protected OneIdService $service)
    {
        $this->url = 'https://sso.egov.uz/sso/oauth/Authorization.do';
    }

    public function authenticate(string $pin): bool
    {
        return Auth::attempt(['pin' => $pin, 'password' => $pin]);
    }

    public function login(Request $request)
    {
        $client = new Client();

        try {
            $res = $client->post('https://sso.egov.uz/sso/oauth/Authorization.do', [
                'query' => [
                    'grant_type' => 'one_access_token_identify',
                    'client_id' => 'tris_uz',
                    'client_secret' => 'E00z0LvtgW5Bta2aAw47nQsp',
//                    'redirect_uri' => 'https://standart.tris.lo',
                        'scope' => 'tris_uz',
'access_token' => '76381f69-d23d-41d8-b023-9bfb44df8ed0'
//                    'state' => 'e-licence',
                ]
            ]);

            dd($res->getBody()->getContents());
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }
        /** @var User $user */
        $user = $this->service->checkRegister($request->all());
        if($this->authenticate($user->pin)) {
//            return true;
            return redirect()->route('dashboard');
        }
        return back()->with(['error']);
    }

    public function sendRequest(Request $request)
    {

    }

    public function getCode(Request $request)
    {

    }

    public function getToken(Request $request)
    {

    }

    public function getInfo(Request $request)
    {

    }

    public function getParams(Request $request)
    {

    }
}
