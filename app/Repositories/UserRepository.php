<?php

namespace App\Repositories;

use App\Models\User;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user)
    {
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    protected function modelClassName()
    {
        return User::class;
    }
}