<?php

namespace Maize\Helpers\Macros;

class ClassUsesTrait
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
