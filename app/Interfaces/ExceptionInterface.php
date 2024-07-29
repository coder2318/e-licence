<?php

namespace App\Interfaces;

interface ExceptionInterface
{
    public function render();
    public function errorResponse($errors, $code, $status=null);
}
