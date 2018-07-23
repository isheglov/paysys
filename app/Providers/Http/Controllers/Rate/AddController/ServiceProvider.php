<?php

namespace App\Providers\Http\Controllers\Rate\AddController;

use App\Http\Controllers\Rate\AddController;
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
            AddController::class,
            function(Container $app) {
                return
                    new AddController(
                        $app->make('paysys.rate.add.service')
                    );
            }
        );
    }
}
