<?php

namespace App\Policies;

use App\Models\User;

class SoftDeleteUserPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if($user->isSuperAdmin()) {
            return true;
        }
        return null;
    }

    public function softDelete(User $user, $targetUser): bool
    {
        if($user->id == $targetUser) {
            return true;
        } else {
            return false;
        }
    }
}
