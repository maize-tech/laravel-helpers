<?php

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

    'macros' => [
        'anonymizeFilename' => \Maize\Helpers\Macros\AnonymizeFilename::class,
        'classUsesTrait' => \Maize\Helpers\Macros\ClassUsesTrait::class,
        'instanceofTypes' => \Maize\Helpers\Macros\InstanceofTypes::class,
        'isUrl' => \Maize\Helpers\Macros\IsUrl::class,
        'modelKeyName' => \Maize\Helpers\Macros\ModelKeyName::class,
        'morphClassOf' => \Maize\Helpers\Macros\MorphClassOf::class,
        'paginationLimit' => \Maize\Helpers\Macros\PaginationLimit::class,
        'sanitizeUrl' => \Maize\Helpers\Macros\SanitizeUrl::class,
    ],

];
