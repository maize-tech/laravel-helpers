<?php

namespace Maize\Helpers\Macros;

use Illuminate\Support\Str;
use Maize\Helpers\HelperMacro;

class SanitizeString implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (?string $value): ?string {
            if (is_null($value)) {
                return null;
            }

            return Str::of($value)
                ->stripTags()
                ->trim()
                ->toString();
        };
    }
}
