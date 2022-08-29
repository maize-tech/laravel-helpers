<?php

namespace Maize\Helpers\Macros;

use Illuminate\Support\Str;

class AnonymizeFilename
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
