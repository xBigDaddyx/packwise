<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'read');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->belongsToTeam($model->currentTeam) && $user->hasTeamPermission($model->currentTeam, 'read') && $user->tokenCan('read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasTeamRole($user->currentTeam, 'admin') && $user->tokenCan('create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->belongsToTeam($model->currentTeam) && $user->hasTeamPermission($model->currentTeam, 'update') && $user->tokenCan('update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->belongsToTeam($model->currentTeam) && $user->hasTeamPermission($model->currentTeam, 'delete') && $user->tokenCan('delete')
            && $user->id !== $model->id; // Prevent self-deletion
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->belongsToTeam($model->currentTeam) && $user->hasTeamPermission($model->currentTeam, 'delete') && $user->tokenCan('delete')
            && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'delete') &&
            $user->hasTeamRole($user->currentTeam, 'admin');
    }
}
