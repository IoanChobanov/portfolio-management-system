<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Project $project): bool { return true; }
    
    public function create(User $user): bool {
        return $user->role === 'admin';
    }
    public function update(User $user, Project $project): bool {
        return in_array($user->role, ['admin', 'editor']);
    }
    public function delete(User $user, Project $project): bool {
        return $user->role === 'admin';
    }
}