<?php

namespace Maize\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Maize\Helpers\Support\Config;

/**
 * @method string anonymizeFilename(string $filename)
 * @method bool classUsesTrait(string $trait, mixed $class)
 * @method bool instanceofTypes(mixed $value, array|string|object $types)
 * @method bool isUrl(mixed $url)
 * @method string modelKeyName(\Illuminate\Database\Eloquent\Model|string $model)
 * @method string morphClassOf(\Illuminate\Database\Eloquent\Model|string $model)
 * @method int paginationLimit(int $default = 16, int $max = 48)
 * @method mixed pipe(mixed $passable, mixed $pipes)
 * @method array|null sanitizeArrayOfStrings(array|null $value, array|string|null $only = null)
 * @method string|null sanitizeString(string|null $value)
 * @method string|null sanitizeUrl(string|null $url)
 */
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
