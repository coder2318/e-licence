<?php

namespace App\Integrations\Eimzo\Responses;

class EimzoChallengeResponse extends EimzoBaseResponseDto
{
    public ?string $challenge = null;
    public ?int $status = null;
    public ?string $message = null;
    public function getChallenge(): ?string
    {
        return $this->challenge;
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }

}
