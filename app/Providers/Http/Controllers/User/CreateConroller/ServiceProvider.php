<?php

namespace App\Providers\Http\Controllers\User\CreateConroller;

use App\Http\Controllers\User\CreateController;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CreateController::class,
            function(Container $app) {
                return
                    new CreateController(
                        $app->make('paysys.user.create.service')
                    );
            }
        );
    }
}
