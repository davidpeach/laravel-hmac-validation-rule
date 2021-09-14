<?php

namespace DavidPeach\LaravelHmacValidatorRule\Tests;

use DavidPeach\LaravelHmacValidatorRule\HmacValidatorRuleServiceProvider;
use \Orchestra\Testbench\TestCase as TC;

class TestCase extends TC
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            HmacValidatorRuleServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
