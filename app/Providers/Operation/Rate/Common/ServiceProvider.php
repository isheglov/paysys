<?php

namespace App\Providers\Operation\Rate\Common;

use App\Operation\Common\CurrencyConverter\CurrencyConverter;
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
            'paysys.currency.converter',
            function(Container $app) {
                return
                    new CurrencyConverter(
                        $app->make('paysys.rate.repository')
                    );
            }
        );
    }
}
