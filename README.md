# Laravel Helpers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maize-tech/laravel-helpers.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-helpers)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/maize-tech/laravel-helpers/run-tests?label=tests)](https://github.com/maize-tech/laravel-helpers/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/maize-tech/laravel-helpers/Check%20&%20fix%20styling?label=code%20style)](https://github.com/maize-tech/laravel-helpers/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maize-tech/laravel-helpers.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-helpers)

This repository contains some useful helpers for most applications using Laravel.

## Installation

You can install the package via composer:

```bash
composer require maize-tech/laravel-helpers
```

You can publish the config file with:
```bash
php artisan vendor:publish --tag="helpers-config"
```

This is the content of the published config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Helper class
    |--------------------------------------------------------------------------
    |
    | Here you may specify the fully qualified class name of the helper class.
    |
    */

   'helper' => Maize\Helpers\Helper::class,

];
```
## Usage

To use the package, you can simply call the `hlp()` helper function, followed by one of the [Available methods](#available-methods) methods listed below.
If needed, you could also call the static method directly.

Here's an example using both the helper function and the static method:

```php
hlp()->sanitizeUrl('mywebsite.com'); // using  the helper function

\Maize\Helpers\Helper::sanitizeUrl('mywebsite.com'); // using the static method
```

## Available methods

- [`paginationLimit`](#paginationlimit)
- [`anonymizeFilename`](#anonymizefilename)
- [`sanitizeUrl`](#sanitizeurl)
- [`instanceofTypes`](#instanceoftypes)
- [`classUsesTrait`](#classusestrait)
- [`morphClassOf`](#morphclassof)
- [`modelKeyName`](#modelkeyname)

### `paginationLimit`

The `paginationLimit` function returns the amount of items per page.

It is useful when working with queries who need a pagination, and allows to define a default pagination limit and the max amount of items per page.

It will also check whether the request's query string contains a `limit` parameter: if true, the given limit overrides the default limit.

```php
use App\Models\Article;

// use the default pagination limit (16 items)
// GET /api/articles
Article::paginate(
    hlp()->paginationLimit() // returns 16 items
);

// use the pagination limit given by the request query string
// GET /api/articles?limit=20
Article::paginate(
    hlp()->paginationLimit() // returns 20 items
);

// provide a custom default pagination limit
// GET /api/articles
Article::paginate(
    hlp()->paginationLimit(30) // returns 30 items
);

// when defined, the request query string limit overrides the default limit
// GET /api/articles?limit=20
Article::paginate(
    hlp()->paginationLimit(30) // returns 20 items
);

// provide a max limit of items for each page
// GET /api/articles?limit=200
Article::paginate(
    hlp()->paginationLimit(16, 50) // returns 50 items
);
```

### `anonymizeFilename`

The `anonymizeFilename` function returns a randomized name of the given file followed by its extension.

```php
string $filename = 'my-custom-file.xml';

// returns a UUID string followed by the file extension
// e.g. 'd437fd98-68d1-4874-b0e7-fac06e587083.xml'
hlp()->anonymizeFilename($filename);
```

### `sanitizeUrl`

The `sanitizeUrl` function returns the lower case of the given url and prefixes it with the `https` protocol if none is set.

```php
hlp()->sanitizeUrl('http://innovation.h-farm.com'); // returns 'http://innovation.h-farm.com'

hlp()->sanitizeUrl('innovation.h-farm.com'); // returns 'https://innovation.h-farm.com'

hlp()->sanitizeUrl('') // returns an empty string
```

### `instanceofTypes`

The `instanceofTypes` function returns whether a class object is an instance of at least one of the given types or not.

```php
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

$model = User::firstOrFail();

hlp()->instanceofTypes($model, Model::class); // returns true

hlp()->instanceofTypes($model, Exception); // returns false

hlp()->instanceofTypes($model, [
    Model::class,
    Exception::class,
]); // returns true
```

### `classUsesTrait`

The `classUsesTrait` function returns whether a class object or name uses the given trait or not.

```php
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;

$model = User::firstOrFail();

hlp()->classUsesTrait(HasFactory::class, $model); // returns true

hlp()->classUsesTrait(HasFactory::class, User::class); // returns true

hlp()->classUsesTrait(Exception::class, $model); // returns false

hlp()->classUsesTrait(Exception::class, User::class); // returns false
```

### `morphClassOf`

The `morphClassOf` function returns the morph class name of a given model object or class name.

```php
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

$model = User::firstOrFail();

hlp()->morphClassOf($model); // returns 'App\Models\User'

hlp()->morphClassOf(User::class); // returns 'App\Models\User'

Relation::enforceMorphMap([
    'user' => User::class,
]);

hlp()->morphClassOf($model); // returns 'user'

hlp()->morphClassOf(User::class); // returns 'user'
```

### `modelKeyName`

The `modelKeyName` function returns the key name of a given model object or class name.

```php
use App\Models\User;

$model = User::firstOrFail();

hlp()->modelKeyName($model); // returns 'id'

hlp()->modelKeyName(User::class); // returns 'id'
```

## Extending the Helper class

If needed, you can easily extend the `Helper` class to add your own methods.

All you have to do is create a new class which overrides the `Helper` base class and adds all the methods you need.
After that, you can override the `helper` attribute from `config/helpers.php` to match the newly created class.

Here's an example of the output class:

```php
<?php

namespace Support\Helpers;

use Maize\Helpers\Helper as BaseHelper;

class Helper extends BaseHelper
{
    public static function awesomeHelper(): string
    {
        return "Just another awesome helper!";
    }
}
```

Whereas the `helpers.php` config file should look like this:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Helper class
    |--------------------------------------------------------------------------
    |
    | Here you may specify the fully qualified class name of the helper class.
    |
    */

   'helper' => Support\Helpers\Helper::class,

];
```

You can then call all your custom-made helper methods using the `hlp()` function:

```php
hlp()->awesomeHelper(); // returns "Just another awesome helper!";
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Enrico De Lazzari](https://github.com/enricodelazzari)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
