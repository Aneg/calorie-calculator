<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        if(empty($user->api_token))
            $user->api_token = str_random(60);
    }

    public function updating(User $user)
    {
        $oldUser = User::find($user->id);
        if($oldUser->email != $user->email || $oldUser->password != $user->password)
            $user->api_token = str_random(60);
    }
}
