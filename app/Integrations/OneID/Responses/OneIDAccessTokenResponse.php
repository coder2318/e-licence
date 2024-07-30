<?php

namespace App\Integrations\OneID\Responses;

class OneIDAccessTokenResponse extends OneIDBaseResponseDto
{
    public ?string $scope = null;
    public ?string $expires_in = null;
    public ?string $token_type = null;
    public ?string $refresh_token = null;
    public ?string $access_token = null;

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

}
