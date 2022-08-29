<?php

namespace Maize\Helpers\Macros;

use Maize\Helpers\HelperMacro;

class IsUrl implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (mixed $url): bool {
            return (bool)filter_var($url, FILTER_VALIDATE_URL);
        };
    }
}
