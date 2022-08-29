<?php

namespace Maize\Helpers\Macros;

use Illuminate\Database\Eloquent\Model;
use Maize\Helpers\HelperMacro;

class MorphClassOf implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (Model|string $model): string {
            if (is_string($model)) {
                $model = app($model);
            }

            return $model->getMorphClass();
        };
    }
}
