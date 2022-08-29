<?php

namespace Maize\Helpers\Macros;

class IsUrl
{
    public function __invoke(): \Closure
    {
        return function (mixed $url): bool {
            return (bool)filter_var($url, FILTER_VALIDATE_URL);
        };
    }
}
