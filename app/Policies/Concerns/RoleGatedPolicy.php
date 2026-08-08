<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait RoleGatedPolicy
{
    abstract protected function allowed(User $user): bool;

    public function viewAny(User $user): bool
    {
        return $this->allowed($user);
    }

    public function view(User $user): bool
    {
        return $this->allowed($user);
    }

    public function create(User $user): bool
    {
        return $this->allowed($user);
    }

    public function update(User $user): bool
    {
        return $this->allowed($user);
    }

    public function delete(User $user): bool
    {
        return $this->allowed($user);
    }

    public function restore(User $user): bool
    {
        return $this->allowed($user);
    }

    public function forceDelete(User $user): bool
    {
        return $this->allowed($user);
    }
}
