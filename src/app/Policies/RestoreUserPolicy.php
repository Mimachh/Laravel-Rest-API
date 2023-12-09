<?php

namespace App\Policies;

use App\Models\User;

class RestoreUserPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if($user->isSuperAdmin()) {
            return true;
        }
        return null;
    }

    public function restoreUser(User $user, $targetUser): bool
    {
        if($user->id == $targetUser) {
            return true;
        } else {
            return false;
        }
    }
}
