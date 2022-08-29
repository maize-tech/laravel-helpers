<?php

namespace Maize\Helpers\Macros;

use Illuminate\Support\Arr;
use Maize\Helpers\HelperMacro;

class InstanceofTypes implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (mixed $value, array|string|object $types): bool {
            foreach (Arr::wrap($types) as $type) {
                if ($value instanceof $type) {
                    return true;
                }
            }

            return false;
        };
    }
}
