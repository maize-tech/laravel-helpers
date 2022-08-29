<?php

namespace Maize\Helpers\Macros;

use Maize\Helpers\HelperMacro;

class ClassUsesTrait implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (string $trait, mixed $class): bool {
            return in_array(
                $trait,
                trait_uses_recursive($class)
            );
        };
    }
}
