<?php

namespace App\Providers\Http\Controllers\Wallet\TransferController;

use App\Http\Controllers\Wallet\TransferController;
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
            TransferController::class,
            function(Container $app) {
                return
                    new TransferController(
                        $app->make('paysys.wallet.transfer.service')
                    );
            }
        );
    }
}
