<?php

namespace App\Providers\Operation\Rate\Add;

use App\Operation\Rate\Add\Service;
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
            'paysys.rate.add.service',
            function(Container $app) {
                return
                    new Service(
                        $app->make('paysys.rate.repository'),
                        $app->make('log')
                    );
            }
        );
    }
}
