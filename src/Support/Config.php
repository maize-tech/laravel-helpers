<?php

namespace Maize\Helpers\Support;

class Config
{
    public static function macros(): array
    {
        return config('helpers.macros', []);
    }
}
