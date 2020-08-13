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

## Usage

1 . Run migrations

```shell script
php artisan migrate
```

1. Add next line to $routeMiddleware array of your Kernel.php file

```php
    'permission' => \MarksIhor\LaravelPermissions\Http\Middleware\PermissionMiddleware::class,
```

## License

MIT