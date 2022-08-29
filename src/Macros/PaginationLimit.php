<?php

namespace Maize\Helpers\Macros;

use Maize\Helpers\HelperMacro;

class PaginationLimit implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (int $default = 16, int $max = 48): int {
            $limit = request()->get('limit') ?? $default;

            return min($limit, $max);
        };
    }
}
