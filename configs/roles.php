<?php

return [
    'routes' => [
        'built_in' => false,
        'prefix' => 'api',
        'namespace' => MarksIhor\LaravelPermissions\Http\Controllers\RoleController::class,
        'middleware' => 'auth:api',
    ]
];
