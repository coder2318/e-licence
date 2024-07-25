<?php

namespace App\Interfaces;

interface IResponse
{
    public function hasError(): bool;

    public function getErrorMessage(): ?string;

    public function getErrorCode(): ?int;

    public function getData(): mixed;
}
