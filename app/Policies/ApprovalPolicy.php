<?php

namespace App\Policies;

use App\Models\Approval;
use App\Models\Boilerplate\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApprovalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Approval $approval)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Approval $approval)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Approval $approval)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Approval $approval)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Boilerplate\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Approval $approval)
    {
        //
    }
}
