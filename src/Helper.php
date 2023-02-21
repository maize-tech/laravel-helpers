<?php

namespace Maize\Helpers;

use Illuminate\Support\Collection;
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

    public static function defaultMacros(): Collection
    {
        return collect([
            'anonymizeFilename' => \Maize\Helpers\Macros\AnonymizeFilename::class,
            'classUsesTrait' => \Maize\Helpers\Macros\ClassUsesTrait::class,
            'instanceofTypes' => \Maize\Helpers\Macros\InstanceofTypes::class,
            'isUrl' => \Maize\Helpers\Macros\IsUrl::class,
            'modelKeyName' => \Maize\Helpers\Macros\ModelKeyName::class,
            'morphClassOf' => \Maize\Helpers\Macros\MorphClassOf::class,
            'paginationLimit' => \Maize\Helpers\Macros\PaginationLimit::class,
            'pipe' => \Maize\Helpers\Macros\Pipe::class,
            'sanitizeArrayOfStrings' => \Maize\Helpers\Macros\SanitizeArrayOfStrings::class,
            'sanitizeString' => \Maize\Helpers\Macros\SanitizeString::class,
            'sanitizeUrl' => \Maize\Helpers\Macros\SanitizeUrl::class,
        ]);
    }
}
