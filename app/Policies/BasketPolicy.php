<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Basket;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the basket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Basket  $basket
     * @return mixed
     */
    public function view(User $user, Basket $basket)
    {
        return $this->isOwner($user, $basket);
    }

    /**
     * Determine whether the user can create baskets.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the basket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Basket  $basket
     * @return mixed
     */
    public function update(User $user, Basket $basket)
    {
        return $this->isOwner($user, $basket);
    }

    /**
     * Determine whether the user can delete the basket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Basket  $basket
     * @return mixed
     */
    public function delete(User $user, Basket $basket)
    {
        return $this->isOwner($user, $basket);
    }

    /**
     * Determine whether the user can restore the basket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Basket  $basket
     * @return mixed
     */
    public function restore(User $user, Basket $basket)
    {
        return $this->isOwner($user, $basket);
    }

    /**
     * Determine whether the user can permanently delete the basket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Basket  $basket
     * @return mixed
     */
    public function forceDelete(User $user, Basket $basket)
    {
        return $this->isOwner($user, $basket);
    }

    private function isOwner(User $user, Basket $basket)
    {
        return $user->id === $basket->user_id;
    }
}
