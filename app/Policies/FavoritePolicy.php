<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy
{
    use HandlesAuthorization;

    public function favoriteReply(User $user, Reply $reply)
    {
        return ! $reply->favorites()
            ->where(['user_id' => $user->id])
            ->exists();
    }

}
