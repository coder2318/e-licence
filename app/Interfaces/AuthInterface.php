<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthInterface
{
    public function authenticate(User $user): bool;

    public function userLogin($params);

    public function adminLogin($params);

}
