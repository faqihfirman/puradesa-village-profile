<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\RoleGatedPolicy;

class ArticlePolicy
{
    use RoleGatedPolicy;

    protected function allowed(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isEditor();
    }
}
