<?php

namespace Maize\Helpers;

use Illuminate\Support\Traits\Macroable;
use Maize\Helpers\Support\Config;

class Helper
{
    use Macroable;

    public static function register(): void
    {
        collect(Config::macros())
            ->reject(fn ($class, $macro) => Helper::hasMacro($macro))
            ->each(fn ($class, $macro) => Helper::macro($macro, app($class)()));
    }
}
