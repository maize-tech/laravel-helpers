<?php

namespace Maize\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Helper
{
    public static function paginationLimit(int $default = 16, int $max = 48): int
    {
        $limit = request()->get('limit') ?? $default;

        return min($limit, $max);
    }

    public static function anonymizeFilename(string $filename): string
    {
        if (empty($filename)) {
            return $filename;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $uuid = Str::uuid();

        return "{$uuid}.{$extension}";
    }

    public static function sanitizeUrl(?string $url): ?string
    {
        if (empty($url)) {
            return $url;
        }

        if (! Str::startsWith($url, ['http://', 'https://'])) {
            return "https://{$url}";
        }

        return $url;
    }

    public static function instanceofTypes(mixed $value, array | string | object $types): bool
    {
        foreach (Arr::wrap($types) as $type) {
            if ($value instanceof $type) {
                return true;
            }
        }

        return false;
    }

    public static function classUsesTrait(string $trait, mixed $class): bool
    {
        return in_array(
            $trait,
            trait_uses_recursive($class)
        );
    }

    public static function morphClassOf(Model | string $model): string
    {
        if (is_string($model)) {
            $model = app($model);
        }

        return $model->getMorphClass();
    }

    public static function modelKeyName(Model | string $model): string
    {
        if (is_string($model)) {
            $model = app($model);
        }

        return $model->getKeyName();
    }
}
