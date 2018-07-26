<?php

namespace App\Providers\Operation\Wallet\History\GetList;

use App\Operation\Wallet\History\GetList\Service;
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
            'paysys.wallet.history.get_list.service',
            function(Container $app) {
                return
                    new Service(
                        $app->make('paysys.history.repository'),
                        $app->make('log')
                    );
            }
        );
    }
}
