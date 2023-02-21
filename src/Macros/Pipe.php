<?php

namespace Maize\Helpers\Macros;

use Illuminate\Pipeline\Pipeline;
use Maize\Helpers\HelperMacro;

class Pipe implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (
            mixed $passable,
            mixed $pipes
        ): mixed {
            return app(Pipeline::class)
                ->send($passable)
                ->through($pipes)
                ->thenReturn();
        };
    }
}
