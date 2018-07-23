<?php

namespace App\Providers\Repositories;

use App\Repositories\HistoryRepository;
use App\Repositories\RateRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
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

        $this->app->bind(
            'paysys.wallet.repository',
            WalletRepository::class
        );

        $this->app->bind(
            'paysys.history.repository',
            HistoryRepository::class
        );

        $this->app->bind(
            'paysys.rate.repository',
            RateRepository::class
        );
    }
}
