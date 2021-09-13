<?php

Route::group(['as' => 'roles.', 'prefix' => 'roles'], function () {
    Route::get('/', [config('roles.routes.namespace'), 'index'])->name('index');
    Route::get('/{roleId}', [config('roles.routes.namespace'), 'show'])->name('show');
    Route::get('/{roleId}/permissions', [config('roles.routes.namespace'), 'rolePermissions'])
        ->name('permissions');
    Route::get('/{roleId}/permissions_grouped', [config('roles.routes.namespace'), 'rolePermissionsGrouped'])
        ->name('rolePermissionsGrouped');
    Route::post('/', [config('roles.routes.namespace'), 'store'])->name('store');
    Route::patch('/{roleId}', [config('roles.routes.namespace'), 'update'])->name('update');
    Route::delete('/{roleId}', [config('roles.routes.namespace'), 'delete'])->name('delete');
    Route::patch('/{roleId}/permissions/{action}', [config('roles.routes.namespace'), 'updatePermissions'])
        ->name('updatePermissions')
        ->where('action', '(attach|detach|update)');
});
Route::get('/permissions', [config('roles.routes.namespace'), 'permissions'])->name('permissions');