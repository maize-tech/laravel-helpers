<?php

namespace Maize\Helpers\Tests;

use Maize\Helpers\HelperServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            HelperServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //
    }
}
