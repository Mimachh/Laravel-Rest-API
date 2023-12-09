<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateUserPolicy
{
    /**
     * Create a new policy instance.
     */
    // public function __construct()
    // {
    //     //
    // }
    public function before(User $user, string $ability): bool|null
    {
        if($user->isSuperAdmin()) {
            return true;
        }
        return null;
    }

    public function update(User $user, $targetUser): bool
    {
        //  || $user->isSuperAdmin()
        // $actualUser = Auth::user();
        if($user->id == $targetUser) {
            return true;
        } else {
            return false;
        }
        // return $actualUser->id == $targetUser;
    }
}
