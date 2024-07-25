<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthInterface
{
    public function authenticate(string $pin): bool;

    public function login(Request $request);

}
