<?php

namespace App\Http\Controllers\V1;

use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Services\EimzoService;
use Illuminate\Http\Request;

class EimzoController extends AuthController implements AuthInterface
{

    public function __construct(protected EimzoService $service)
    {
    }

    public function userLogin($params): \Illuminate\Http\RedirectResponse
    {
        /** @var User $user */
                $user = $this->service->checkRegister($params);
        $this->service->getRole($user, User::ROLE_USER);

        if ($this->authenticate($user)) {
            return redirect()->route('application.index');
        }
        return back()->with(['error']);
    }

    public function adminLogin($params)
    {
        // TODO: Implement adminLogin() method.
    }

    public function challenge()
    {
        return $this->service->challenge();
    }

    public function auth(Request $request)
    {
        return response()->json($this->service->auth($request));
    }
}
