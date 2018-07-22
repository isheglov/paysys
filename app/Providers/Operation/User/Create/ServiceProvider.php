<?php

namespace App\Providers\Operation\User\Create;

use App\Operation\User\Create\Service;
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
            'paysys.user.create.service',
            function(Container $app) {
                return
                    new Service(
                        $app->make('paysys.user.repository'),
                        $app->make('log')
                    );
            }
        );
    }
}
