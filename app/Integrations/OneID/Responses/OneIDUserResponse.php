<?php

namespace App\Integrations\OneID\Responses;

class OneIDUserResponse extends OneIDBaseResponseDto
{
    const LOGIN_PASSWORD_METHOD = 'LOGINPASSMETHOD';
    const MOBILE_ID_METHOD = 'MOBILEMETHOD';
    const ESI_PERSONAL_METHOD = 'PKCSMETHOD';
    const ESI_JURIDIC_METHOD = 'LEPKCSMETHOD';
    const GENDER_TYPE_I = 'I';

    public ?string $valid = null;
    public ?string $pin = null;
    public ?string $pport_no = null;
    public ?string $first_name = null;
    public ?string $sur_name = null;
    public ?string $mid_name = null;
    public ?string $full_name = null;
    public ?string $user_id = null;
    public ?string $auth_method = null;
    public ?string $user_type = null;
    public ?string $ret_cd = null;
    public ?string $sess_id = null;
    public ?string $pkcs_legal_tin = null;
    public ?array $legal_info = [];

    public function getPin(): ?string
    {
        return $this->pin;
    }

    public function getPassport(): ?string
    {
        return $this->pport_no;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function isJuridic(): ?string
    {
        if ($this->auth_method === self::ESI_JURIDIC_METHOD)
            return true;
        return false;
    }

    public function getLegalTin(): ?string
    {
        if($this->isJuridic())
            return $this->pkcs_legal_tin;
        return null;
    }

    public function getLegalInfo(): ?array
    {
        if($this->isJuridic())
            return $this->legal_info;
        return null;
    }

    public function gender(): int
    {
        if($this->user_type == self::GENDER_TYPE_I)
            return 1; // erkak
        return 2; // ayol
    }


}
