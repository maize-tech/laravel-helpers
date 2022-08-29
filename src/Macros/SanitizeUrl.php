<?php

namespace Maize\Helpers\Macros;

use Illuminate\Support\Str;
use Maize\Helpers\HelperMacro;

class SanitizeUrl implements HelperMacro
{
    public function __invoke(): \Closure
    {
        return function (?string $url): ?string {
            if (empty($url)) {
                return $url;
            }

            if (! Str::startsWith($url, ['http://', 'https://'])) {
                return "https://{$url}";
            }

            return $url;
        };
    }
}
