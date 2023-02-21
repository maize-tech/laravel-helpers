<?php

namespace Maize\Helpers\Macros;

use Maize\Helpers\HelperMacro;

class SanitizeArrayOfStrings implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (array|null $value, array|string|null $only = null): array|null {
            if (is_null($value)) {
                return null;
            }

            return collect($value)
                ->only($only)
                ->map(
                    fn ($item) => app(SanitizeString::class)()($item)
                )
                ->filter()
                ->toArray();
        };
    }
}
