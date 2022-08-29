<?php

namespace Maize\Helpers;

interface HelperMacro
{
    public function __invoke(): \Closure;
}
