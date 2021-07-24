<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilters extends Filters
{
    protected array $filters = ['by'];

    /**
     * Filter the query by a given username.
     * @param string $username
     * @return Builder
     */
    protected function by(string $username): Builder
    {
        $user = User::whereName($username)
            ->firstOrFail();

        return $this->query->where('user_id', $user->id);
    }

}
