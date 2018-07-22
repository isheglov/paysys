<?php

namespace App\Providers\Http\Controllers\Wallet\ChargeController;

use App\Http\Controllers\Wallet\ChargeController;
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
            ChargeController::class,
            function(Container $app) {
                return
                    new ChargeController(
                        $app->make('paysys.wallet.charge.service')
                    );
            }
        );
    }
}
