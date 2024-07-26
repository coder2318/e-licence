<?php

namespace App\Http\Controllers\V1;

use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Services\OneIdService;
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
        /** @var User $user */
        $user = $this->service->checkRegister($request->all());
        if($this->authenticate($user->pin)) {
            return true;
//            return redirect()->route('dashboard');
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
