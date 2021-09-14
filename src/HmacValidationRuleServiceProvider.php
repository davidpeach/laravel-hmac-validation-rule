<?php

namespace DavidPeach\LaravelHmacValidationRule;

use Illuminate\Support\ServiceProvider;

class HmacValidationRuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'hmac_validation');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('hmac_validation.php'),
            ], 'config');

        }
    }
}
