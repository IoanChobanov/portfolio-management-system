<?php

namespace App\Policies;

use App\Models\Technology;
use App\Models\User;

class TechnologyPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Technology $technology): bool { return true; }

    public function create(User $user): bool {
        return $user->role === 'admin';
    }
    public function update(User $user, Technology $technology): bool {
        return in_array($user->role, ['admin', 'editor']);
    }
    public function delete(User $user, Technology $technology): bool {
        return $user->role === 'admin';
    }
}