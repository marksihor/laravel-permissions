<?php

Route::group(['as' => 'roles', 'prefix' => 'roles'], function () {
    Route::get('/', [config('roles.routes.namespace'), 'index']);
    Route::get('/{roleId}', [config('roles.routes.namespace'), 'show']);
    Route::get('/{roleId}/permissions', [config('roles.routes.namespace'), 'rolePermissions']);
    Route::get('/{roleId}/permissions_grouped', [config('roles.routes.namespace'), 'rolePermissionsGrouped']);
    Route::post('/', [config('roles.routes.namespace'), 'store']);
    Route::patch('/{roleId}', [config('roles.routes.namespace'), 'update']);
    Route::delete('/{roleId}', [config('roles.routes.namespace'), 'delete']);
    Route::patch('/{roleId}/permissions/{action}', [config('roles.routes.namespace'), 'updatePermissions'])
        ->where('action', '(attach|detach|update)');
});
Route::get('/permissions', [config('roles.routes.namespace'), 'permissions']);
