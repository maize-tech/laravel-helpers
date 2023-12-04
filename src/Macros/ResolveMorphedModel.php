<?php

namespace Maize\Helpers\Macros;

use Illuminate\Database\Eloquent\Relations\Relation;
use Maize\Helpers\HelperMacro;

class ResolveMorphedModel implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (string $alias): string {
            return Relation::getMorphedModel(
                str()->singular($alias)
            ) ?? $alias;
        };
    }
}
