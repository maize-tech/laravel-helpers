<?php

namespace Maize\Helpers\Macros;

use Illuminate\Database\Eloquent\Model;

class ModelKeyName
{
    public function __invoke(): \Closure
    {
        return function (Model|string $model): string {
            if (is_string($model)) {
                $model = app($model);
            }

            return $model->getKeyName();
        };
    }
}
