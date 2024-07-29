<?php

namespace App\Integrations\OneID\Responses;

use App\Integrations\OneID\Traits\AutoSetTrait;

abstract class OneIDBaseResponseDto
{
    use AutoSetTrait;

    public function __construct($data)
    {
        $this->loadPropertiesDynamically($data);
    }
}
