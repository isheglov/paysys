<?php

namespace App\Providers\Operation\Wallet\History\Add\Processor;

use App\Operation\Wallet\History\Add\Processor;
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
            'paysys.wallet.history.add.processor',
            function(Container $app) {
                return
                    new Processor(
                        $app->make('paysys.history.repository')
                    );
            }
        );
    }
}
