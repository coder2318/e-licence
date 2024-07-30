<?php

namespace App\Integrations\Eimzo\Responses;

use App\Integrations\Base\Traits\AutoSetTrait;

abstract class EimzoBaseResponseDto
{
    use AutoSetTrait;

    public function __construct($data)
    {
        $this->loadPropertiesDynamically($data);
    }
}
