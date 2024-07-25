<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class HelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'layoutHelper';
    }
}
