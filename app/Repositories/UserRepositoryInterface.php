<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user);
}