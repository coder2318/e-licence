<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OneIdService
{

    public function checkRegister($params): User|Model
    {
        dd($params);
        return User::query()->updateOrCreate([
            'pin' => $params['pin'],
        ], [
            'passport' => $params['passport'],
            'username' => 'test',
            'password' => $params['pin'],
            'f_name' => 'Farrukh',
            'l_name' => 'Choriyev',
        ]);
    }
}
