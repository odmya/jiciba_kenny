<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id||$currentUser->is_admin;
    }


    public function access(User $currentUser, User $user)
    {
        return $currentUser->is_admin;
    }



    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

}
