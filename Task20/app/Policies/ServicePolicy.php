<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function edit()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete()
    {
        return auth()->user()->hasRole('Admin');
    }
}
