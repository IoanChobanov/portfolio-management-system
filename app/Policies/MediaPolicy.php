<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;

class MediaPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Media $media): bool { return true; }

    public function create(User $user): bool {
        return in_array($user->role, ['admin', 'editor']);
    }
    public function update(User $user, Media $media): bool {
        return in_array($user->role, ['admin', 'editor']);
    }
    public function delete(User $user, Media $media): bool {
        return $user->role === 'admin';
    }
}