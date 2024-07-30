<?php

namespace App\Integrations\Eimzo\Responses;

class EimzoUserResponse extends EimzoBaseResponseDto
{
    public ?array $subjectName = [];

    public function getSubject(): ?array
    {
        return $this->subjectName;
    }

    public function getPin(): ?string
    {
        return $this->getSubject()['1.2.860.3.16.1.2'];
    }

    public function getFName(): ?string
    {
        return $this->getSubject()['Name'];
    }

    public function getLName(): ?string
    {
        return $this->getSubject()['SURNAME'];
    }

    public function getTin(): ?string
    {
        return $this->getSubject()['UID'];
    }


}
