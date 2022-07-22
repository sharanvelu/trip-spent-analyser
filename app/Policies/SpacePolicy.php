<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the space can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list spaces');
    }

    /**
     * Determine whether the space can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Space  $model
     * @return mixed
     */
    public function view(User $user, Space $model)
    {
        return $user->hasPermissionTo('view spaces');
    }

    /**
     * Determine whether the space can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create spaces');
    }

    /**
     * Determine whether the space can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Space  $model
     * @return mixed
     */
    public function update(User $user, Space $model)
    {
        return $user->hasPermissionTo('update spaces');
    }

    /**
     * Determine whether the space can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Space  $model
     * @return mixed
     */
    public function delete(User $user, Space $model)
    {
        return $user->hasPermissionTo('delete spaces');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Space  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete spaces');
    }

    /**
     * Determine whether the space can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Space  $model
     * @return mixed
     */
    public function restore(User $user, Space $model)
    {
        return false;
    }

    /**
     * Determine whether the space can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Space  $model
     * @return mixed
     */
    public function forceDelete(User $user, Space $model)
    {
        return false;
    }
}
