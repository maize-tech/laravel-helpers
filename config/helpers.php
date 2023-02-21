<?php

use Maize\Helpers\Helper;

return [

    /*
    |--------------------------------------------------------------------------
    | Helper macros
    |--------------------------------------------------------------------------
    |
    | Here you may specify the full list of helper macros which will automatically
    | be registered on boot.
    | The key defines the method name, whereas the value should be the
    | fully qualified name of the invokable class.
    |
    */

    'macros' => Helper::defaultMacros()->merge([
        // 'methodName' => App\Example\ExampleClass::class,
    ])->toArray(),

];
