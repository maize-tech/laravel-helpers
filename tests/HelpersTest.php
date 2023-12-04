<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User;
use Maize\Helpers\Tests\Support\Models\Article;
use Maize\Helpers\Tests\Support\Models\Post;

use function PHPUnit\Framework\assertNotEquals;

beforeEach(function () {
    Relation::morphMap(['article' => Article::class]);
});

it('anonymizeFilename', function (?string $name, ?string $ext) {
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

it('classUsesTrait', function (string $trait, mixed $class, bool $result) {
    expect(hlp()->classUsesTrait($trait, $class))->toBe($result);
})->with([
    ['trait' => HasFactory::class, 'class' => Article::class, 'result' => true],
    ['trait' => HasFactory::class, 'class' => new Article(), 'result' => true],
    ['trait' => Article::class, 'class' => HasFactory::class, 'result' => false],
    ['trait' => Article::class, 'class' => User::class, 'result' => false],
    ['trait' => HasFactory::class, 'class' => User::class, 'result' => false],
]);

it('instanceofTypes', function (mixed $value, mixed $types, bool $result) {
    expect(hlp()->instanceofTypes($value, $types))->toBe($result);
})->with([
    ['value' => null, 'types' => [], 'result' => false],
    ['value' => null, 'types' => [Model::class], 'result' => false],
    ['value' => User::class, 'types' => [Model::class], 'result' => false],
    ['value' => new User(), 'types' => [Model::class], 'result' => true],
    ['value' => new User(), 'types' => [Model::class, 'test'], 'result' => true],
    ['value' => new User(), 'types' => ['test'], 'result' => false],
    ['value' => new class () {
    }, 'types' => ['test'], 'result' => false],
    ['value' => new User(), 'types' => User::class, 'result' => true],
    ['value' => new User(), 'types' => new User(), 'result' => true],
    ['value' => new User(), 'types' => new class () {
    }, 'result' => false],
    ['value' => new User(), 'types' => new Article(), 'result' => false],
]);

it('isUrl', function () {
    expect(hlp()->isUrl('https://my-application.test'))
        ->toBe(true)
        ->and(hlp()->isUrl('not-an-url'))
        ->toBe(false);
});

it('modelKeyName', function (mixed $model, string $result) {
    expect(hlp()->modelKeyName($model))->toBe($result);
})->with([
    ['model' => Article::class, 'result' => 'id'],
    ['model' => new Article(), 'result' => 'id'],
]);

it('morphClassOf', function (mixed $model, string $result) {
    expect(hlp()->morphClassOf($model))->toBe($result);
})->with([
    ['model' => Article::class, 'result' => 'article'],
    ['model' => new Article(), 'result' => 'article'],
]);

it('resolveMorphedModel', function (mixed $model, ?string $result) {
    expect(hlp()->resolveMorphedModel($model))->toBe($result);
})->with([
    ['model' => 'article', 'result' => Article::class],
    ['model' => 'articles', 'result' => Article::class],
    ['model' => Post::class, 'result' => Post::class],
]);

it('paginationLimit', function (?int $limit, ?int $default, ?int $max, int $result) {
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

it('pipe', function ($passable, $pipes, $result) {
    expect(hlp()->pipe($passable, $pipes))->toBe($result);
})->with([
    ['passable' => null, 'pipes' => [], 'result' => null],
    ['passable' => [], 'pipes' => [], 'result' => []],
    ['passable' => '', 'pipes' => [], 'result' => ''],
    ['passable' => 'test', 'pipes' => [], 'result' => 'test'],
    ['passable' => 'test', 'pipes' => [
        \Maize\Helpers\Tests\Support\Actions\Uppercase::class,
        \Maize\Helpers\Tests\Support\Actions\Reverse::class,
    ], 'result' => 'TSET'],
    ['passable' => 'test', 'pipes' => [
        \Maize\Helpers\Tests\Support\Actions\Reverse::class,
        \Maize\Helpers\Tests\Support\Actions\Uppercase::class,
    ], 'result' => 'TSET'],
    ['passable' => 'test', 'pipes' => [
        \Maize\Helpers\Tests\Support\Actions\Uppercase::class,
    ], 'result' => 'TEST'],
    ['passable' => 'test', 'pipes' => [
        \Maize\Helpers\Tests\Support\Actions\Reverse::class,
    ], 'result' => 'tset'],
]);

it('sanitizeString', function (?string $string, $result) {
    expect(hlp()->sanitizeString($string))->toBe($result);
})->with([
    ['string' => null, 'result' => null],
    ['string' => '', 'result' => ''],
    ['string' => '   test   ', 'result' => 'test'],
    ['string' => '<h1>   test   </h1>', 'result' => 'test'],
    ['string' => '   <h1>   test   </h1>   ', 'result' => 'test'],
    ['string' => '   test   </h1>   ', 'result' => 'test'],
    ['string' => '   <h1>   test   ', 'result' => 'test'],
    ['string' => 'test<br>', 'result' => 'test'],
    ['string' => 'test<br />', 'result' => 'test'],
    ['string' => '<h1></h1>', 'result' => ''],
    ['string' => '<br />', 'result' => ''],
]);

it('sanitizeArrayOfStrings', function (?array $array, $result) {
    expect(hlp()->sanitizeArrayOfStrings($array))->toBe($result);
})->with([
    ['array' => null, 'result' => null],
    ['array' => [], 'result' => []],
    ['array' => [null], 'result' => []],
    ['array' => ['a' => ''], 'result' => []],
    ['array' => ['a' => null], 'result' => []],
    ['array' => ['   test   ', '   test   '], 'result' => ['test', 'test']],
    ['array' => ['a' => '   test   ', 'b' => '   test   '],'result' => ['a' => 'test', 'b' => 'test']],
    ['array' => ['a' => '<h1>   test   </h1>', 'b' => '<h1>   test   </h1>'],'result' => ['a' => 'test', 'b' => 'test']],
    ['array' => ['a' => '   <h1>   test   </h1>   ', 'b' => '   <h1>   test   </h1>   '],'result' => ['a' => 'test', 'b' => 'test']],
    ['array' => ['a' => '   test   </h1>   ', 'b' => '   test   </h1>   '],'result' => ['a' => 'test', 'b' => 'test']],
    ['array' => ['   test   </h1>   ', '   test   </h1>   '], 'result' => ['test', 'test']],
    ['array' => ['   <h1>   test   ', '   <h1>   test   '], 'result' => ['test', 'test']],
    ['array' => ['test<br>', 'test<br>'], 'result' => ['test', 'test']],
    ['array' => ['test<br />', 'test<br />'], 'result' => ['test', 'test']],
    ['array' => ['<h1></h1>', '<h1></h1>'], 'result' => []],
    ['array' => ['<br />', '<br />'], 'result' => []],
]);

it('sanitizeUrl', function (?string $url, $result) {
    expect(hlp()->sanitizeUrl($url))->toBe($result);
})->with([
    ['url' => null, 'result' => null],
    ['url' => 'https://test.test', 'result' => 'https://test.test'],
    ['url' => 'http://test.test', 'result' => 'http://test.test'],
    ['url' => 'test.test', 'result' => 'https://test.test'],
]);

it('can add macros', function () {
    hlp()->macro('foo', fn (): string => 'macroable');

    expect(hlp()->foo())->toBe('macroable');
});
