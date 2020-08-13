<?php

namespace MarksIhor\LaravelPermissions\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (app('auth')->check()) {
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);

            foreach ($permissions as $key => $permission) {
                if (app('auth')->user()->role->hasPermission($permission)) {
                    if ($key === array_key_last($permissions)) return $next($request);
                }
            }
        }

        throw new AuthorizationException;
    }
}
