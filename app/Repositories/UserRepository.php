<?php

namespace App\Repositories;

use App\Models\User;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user)
    {
        $user->save();
    }
}