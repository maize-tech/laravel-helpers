<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Maize\Helpers\Tests\Models\Article;

use function PHPUnit\Framework\assertNotEquals;

it('can get pagination limit', function (?int $limit, ?int $default, ?int $max, int $result) {
    if (! is_null($limit)) {
        request()->merge([
            'limit' => $limit,
        ]);
    }

    if (! is_null($max)) {
        expect(hlp()->paginationLimit($default, $max))->toBe($result);

        return;
    }

    if (! is_null($default)) {
        expect(hlp()->paginationLimit($default))->toBe($result);

        return;
    }

    expect(hlp()->paginationLimit())->toBe($result);
})->with([
    ['limit' => null, 'default' => null, 'max' => null, 'result' => 16],
    ['limit' => 49, 'default' => null, 'max' => null, 'result' => 48],
    ['limit' => null, 'default' => 8, 'max' => null, 'result' => 8],
    ['limit' => 500, 'default' => 16, 'max' => 200, 'result' => 200],

]);

it('can anonymize filename', function (?string $name, ?string $ext) {
    $filename = "{$name}{$ext}";
    $expect = expect(hlp()->anonymizeFilename($filename));

    if (empty($filename)) {
        $expect->toBeEmpty();

        return;
    }

    $expect->toEndWith($ext);
    assertNotEquals($expect, $filename);
})->with([
    ['filename' => '', 'ext' => ''],
    ['name' => 'test', 'ext' => '.zip'],
    ['name' => 'test-test', 'ext' => '.jpg'],
]);

it('can sanitize url', function (?string $url, $result) {
    expect(hlp()->sanitizeUrl($url))->toBe($result);
})->with([
    ['url' => null, 'result' => null],
    ['url' => 'https://test.test', 'result' => 'https://test.test'],
    ['url' => 'http://test.test', 'result' => 'http://test.test'],
    ['url' => 'test.test', 'result' => 'https://test.test'],
]);

it('is instance of types', function (mixed $value, mixed $types, bool $result) {
    expect(hlp()->instanceofTypes($value, $types))->toBe($result);
})->with([
    ['value' => null, 'types' => [], 'result' => false],
    ['value' => null, 'types' => [Model::class], 'result' => false],
    ['value' => User::class, 'types' => [Model::class], 'result' => false],
    ['value' => new User(), 'types' => [Model::class], 'result' => true],
    ['value' => new User(), 'types' => [Model::class, 'test'], 'result' => true],
    ['value' => new User(), 'types' => ['test'], 'result' => false],
    ['value' => new class () {}, 'types' => ['test'], 'result' => false],
    ['value' => new User(), 'types' => User::class, 'result' => true],
    ['value' => new User(), 'types' => new User(), 'result' => true],
    ['value' => new User(), 'types' => new class () {}, 'result' => false],
    ['value' => new User(), 'types' => new Article(), 'result' => false],
]);

it('class uses trait', function (string $trait, mixed $class, bool $result) {
    expect(hlp()->classUsesTrait($trait, $class))->toBe($result);
})->with([
    ['trait' => HasFactory::class, 'class' => Article::class, 'result' => true],
    ['trait' => HasFactory::class, 'class' => new Article(), 'result' => true],
    ['trait' => Article::class, 'class' => HasFactory::class, 'result' => false],
    ['trait' => Article::class, 'class' => User::class, 'result' => false],
    ['trait' => HasFactory::class, 'class' => User::class, 'result' => false],
]);

it('can get morph class of', function (mixed $model, string $result) {
    expect(hlp()->morphClassOf($model))->toBe($result);
})->with([
    ['model' => Article::class, 'result' => Article::class],
    ['model' => new Article(), 'result' => Article::class],
]);

it('can get model key name', function (mixed $model, string $result) {
    expect(hlp()->modelKeyName($model))->toBe($result);
})->with([
    ['model' => Article::class, 'result' => 'id'],
    ['model' => new Article(), 'result' => 'id'],
]);

it('is macroable', function () {
    hlp()->macro('foo', fn () => 'macroable');

    expect(hlp()->foo())->toBe('macroable');
});
