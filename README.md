# laravel-metas
Laravel Roles and Permissions package.

## Installing

```shell
$ composer require marksihor/laravel-permissions -vvv
```

### Migrations

This step is optional, if you want to customize the tables, you can publish the migration files:

```php
$ php artisan vendor:publish --provider="MarksIhor\\LaravelPermissions\\PermissionsServiceProvider" --tag=migrations
```

This step is optional, if you want to get crud controller run the command:

```php
$ php artisan vendor:publish --provider="MarksIhor\\LaravelPermissions\\PermissionsServiceProvider" --tag=controllers
```

## Usage

1 . Run migrations

```shell script
php artisan migrate
```

2. Add next line to $routeMiddleware array of your Kernel.php file

```php
    'permission' => \MarksIhor\LaravelPermissions\Http\Middleware\PermissionMiddleware::class,
```

3. Add role relationship to your user model

```php
public function role()
{
    return $this->belongsTo('MarksIhor\LaravelPermissions\Models\Role');
}
```

4. Use it on route like this

```php
Route::get('/', 'UserController@index')->middleware('permission:view users');
```

5. Or in other places like this

```php
app('auth')->user()->role->hasPermission($permissionName); // bool
```

## License

MIT