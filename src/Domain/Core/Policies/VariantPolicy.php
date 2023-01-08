<?php

namespace Domain\Core\Policies;

use Domain\Core\Models\Variant;
use Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VariantPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Variant $variant): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Variant $variant): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Variant $variant): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, Variant $variant): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Variant $variant): bool
    {
        return $user->is_admin;
    }
}
