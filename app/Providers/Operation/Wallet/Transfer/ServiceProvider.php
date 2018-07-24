<?php

namespace App\Providers\Operation\Wallet\Transfer;

use App\Operation\Wallet\Transfer\Service;
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
            'paysys.wallet.transfer.service',
            function(Container $app) {
                return
                    new Service(
                        $app->make('paysys.wallet.repository'),
                        $app->make('paysys.wallet.history.add.processor'),
                        $app->make('paysys.currency.converter'),
                        $app->make('log')
                    );
            }
        );
    }
}
