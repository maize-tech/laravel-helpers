<?php

namespace Maize\Helpers\Tests\Support;

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
}
