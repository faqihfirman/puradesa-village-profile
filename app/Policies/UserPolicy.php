<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\RoleGatedPolicy;

class UserPolicy
{
    use RoleGatedPolicy;

    protected function allowed(User $user): bool
    {
        return $user->isSuperAdmin();
    }
}
