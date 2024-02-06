<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\TomanClient;
use App\Models\User;

class TomanClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TomanClient $tomanClient)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TomanClient $tomanClient)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TomanClient $tomanClient)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TomanClient $tomanClient)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TomanClient $tomanClient)
    {
        //
    }
}
