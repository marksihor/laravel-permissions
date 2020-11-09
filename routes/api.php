<?php

Route::group(['as' => 'roles'], function () {
    Route::get('/', [config('roles.routes.namespace'), 'index']);
    Route::get('/{model}', [config('roles.routes.namespace'), 'show']);
    Route::get('/{model}/permissions', [config('roles.routes.namespace'), 'permissions']);
    Route::post('/', [config('roles.routes.namespace'), 'store']);
    Route::patch('/{model}', [config('roles.routes.namespace'), 'update']);
    Route::delete('/{model}', [config('roles.routes.namespace'), 'delete']);
    Route::patch('/{model}/permissions/{action}', [config('roles.routes.namespace'), 'updatePermissions'])
        ->where('action', '(attach|detach|update)');
});
