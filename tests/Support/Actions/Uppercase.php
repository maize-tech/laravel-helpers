<?php

namespace Maize\Helpers\Tests\Support\Actions;

class Uppercase
{
    public function handle(string $string, \Closure $next): string
    {
        return $next(
            strtoupper($string)
        );
    }
}
