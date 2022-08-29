<?php

namespace Maize\Helpers\Macros;

use Illuminate\Support\Str;
use Maize\Helpers\HelperMacro;

class AnonymizeFilename implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (string $filename): string {
            if (empty($filename)) {
                return $filename;
            }

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $uuid = Str::uuid();

            return "{$uuid}.{$extension}";
        };
    }
}
