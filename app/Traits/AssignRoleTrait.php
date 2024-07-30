<?php

namespace App\Traits;

use App\Models\User;

trait AssignRoleTrait
{
    /**
     * @param $user
     * @param $role
     * @return void
     */
    public function getRole($user, $role): void
    {
        /** @var User $user */
        if(!in_array($role, $user->getUserRoleNames()))
            $user->assignRole($role);
    }
}
