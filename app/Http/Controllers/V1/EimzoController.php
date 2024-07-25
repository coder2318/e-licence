<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;

class EimzoController extends AuthController implements AuthInterface
{

    public function authenticate(string $pin): bool
    {
        // TODO: Implement authenticate() method.
    }

    public function login(Request $request): bool
    {
        // TODO: Implement login() method.
    }
}
