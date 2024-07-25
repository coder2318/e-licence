<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function loginPage()
    {
        return view('content.authentications.auth-login-basic');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function assignRole(Request $request)
    {
        $user = $this->getAuthUser();
        $user->assignRole($request->role);
        return response()->json($user->getRoleNames());
    }

    public function getAuthUser(): ?Authenticatable
    {
        return Auth::user();
    }


}
