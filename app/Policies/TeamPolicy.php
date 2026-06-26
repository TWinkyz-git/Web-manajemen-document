<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        // Can view if user is team member or creator
        return $user->id === $team->created_by || $team->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool
    {
        // Only creator or team leader can update
        if ($user->id === $team->created_by) {
            return true;
        }

        return $team->members()
            ->where('user_id', $user->id)
            ->where('role', 'leader')
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        // Only creator can delete
        return $user->id === $team->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Team $team): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Team $team): bool
    {
        return false;
    }
}