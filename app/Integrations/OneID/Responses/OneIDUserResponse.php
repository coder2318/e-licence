<?php

namespace App\Integrations\OneID\Responses;

class OneIDUserResponse extends OneIDBaseResponseDto
{
    public ?string $id = null;
    public ?string $create_time = null;
    public ?string $name = null;
    public ?array $versions = null;

    public function getVersions(): ?array
    {
        return $this->versions;
    }

}
