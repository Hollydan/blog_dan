<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy extends Policy
{

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
