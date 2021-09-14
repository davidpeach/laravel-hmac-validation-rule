<?php

namespace DavidPeach\LaravelHmacValidationRule\Tests;

use DavidPeach\LaravelHmacValidationRule\HmacValidationRuleServiceProvider;
use \Orchestra\Testbench\TestCase as TC;

class TestCase extends TC
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app): array
    {
        return [
            HmacValidationRuleServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
