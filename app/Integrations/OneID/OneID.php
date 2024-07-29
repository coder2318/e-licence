<?php

namespace App\Integrations\OneID;

use App\Integrations\OneID\Classes\UserData;
use App\Integrations\OneID\Utils\AgrodoxClient;
use App\Integrations\OneID\Utils\OneIDClient;

class OneID
{
    protected ?UserData $userData = null;

    public function userData(): UserData
    {
        if (!$this->userData) {
            $OneIDClient = new OneIDClient(config('integrations.oneID.url'), config('integrations.oneID.client_id'), config('integrations.oneID.client_secret'));
            $this->userData = new UserData($OneIDClient);
        }
        return $this->userData;
    }

}
