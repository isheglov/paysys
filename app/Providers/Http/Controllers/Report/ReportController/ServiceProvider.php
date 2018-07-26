<?php

namespace App\Providers\Http\Controllers\Report\ReportController;

use App\Http\Controllers\Report\ReportController;
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
            ReportController::class,
            function(Container $app) {
                return
                    new ReportController(
                        $app->make('paysys.wallet.history.get_list.service'),
                        $app->make('paysys.history.repository')
                    );
            }
        );
    }
}
