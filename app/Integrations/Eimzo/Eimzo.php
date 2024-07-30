<?php

namespace App\Integrations\Eimzo;

use App\Integrations\Eimzo\Classes\UserData;
use App\Integrations\Eimzo\Utils\EimzoClient;

class Eimzo
{
    protected ?UserData $userData = null;

    public function userData(): UserData
    {
        if (!$this->userData) {
            $EimzoClient = new EimzoClient(config('integrations.eimzo.base_url'), config('integrations.eimzo.challenge_url'), config('integrations.eimzo.auth_url'));
            $this->userData = new UserData($EimzoClient);
        }
        return $this->userData;
    }

}
