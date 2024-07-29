<?php

namespace App\Integrations\OneID\Traits;

trait AutoSetTrait
{
    public function loadPropertiesDynamically(array $data): void
    {
        foreach ($data as $param => $value) {
            if (property_exists($this, $param)) {
                $this->{$param} = $value;
            }
        }
    }
}
