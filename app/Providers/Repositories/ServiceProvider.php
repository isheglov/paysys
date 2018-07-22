<?php

namespace App\Providers\Repositories;

use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'paysys.user.repository',
            UserRepository::class
        );
    }
}
