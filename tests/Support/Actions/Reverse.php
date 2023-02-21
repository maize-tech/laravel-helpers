<?php

namespace Maize\Helpers\Tests\Support\Actions;

class Reverse
{
    public function __invoke(string $string, \Closure $next): string
    {
        return $next(
            strrev($string)
        );
    }
}
