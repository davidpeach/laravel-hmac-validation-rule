<?php

namespace DavidPeach\LaravelHmacValidatorRule;

use Illuminate\Support\ServiceProvider;

class HmacValidatorRuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'hmac_validator');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('hmac_validator.php'),
            ], 'config');

        }
    }
}
