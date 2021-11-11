# Publishing File Groups

Modules and Boxes are all [Laravel Service Providers](https://laravel.com/docs/8.x/providers).
Therefore you can use all the features Laravel provides for package development.

Concord modules provide several convenience features compared to the base Laravel service providers.

One of those features is that some [file groups are published](https://laravel.com/docs/8.x/packages#publishing-file-groups)
by default.

## Migrations

Concord modules and boxes are publishing their migration, therefore they can be copied to the
application using the `artisan vendor:publish` command.

```bash
php artisan vendor:publish --provider="Vendor\Module\Providers\ModuleServiceProvider" --tag="migrations"
```

Using this feature is useful if you want your application to control the migrations. In this case
you likely need to [turn off the loading of migrations]((migrations.md#turn-migrations-onoff))
on the module level.

One of such use-cases is when you're using the modules in a multi-tenant environment. Depending on
the setup, the tenant migrations have to be separated from the "landlord" migrations.

> As an example see: [Tenancy for Laravel](https://tenancyforlaravel.com/docs/v3/migrations) or
> [Spatie Laravel-Multitenancy](https://docs.spatie.be/laravel-multitenancy/v1/installation/using-multiple-databases/#migrating-the-landlord-database).

### Difference Between Publishing and Loading Migrations

It might be confusing, what is publishing and what is loading of migrations.

**Loading** is when a set of migrations are made visible for `artisan migrate` command.
These migrations are available to be **executed** on demand. See https://laravel.com/docs/8.x/packages#migrations

**Publishing** is when a set of files (eg. migrations) are made visible for the
`artisan vendor:publish` command. These files can be **copied** to your application's migrations
folder. See https://laravel.com/docs/8.x/packages#publishing-file-groups

The main differences are:

- If the module loads the migrations, they are ran from the module's own folder.
- If migrations are loaded by the module, newly added migrations are immediately visible for the app.
- If migrations are copied, the files are copied from the module's folder to the app's folder.
- If migrations are copied, the newer migrations added by the module will only be copied if you run the `vendor:publish` command again.
- If migrations are both copied and loaded, then the migrations will be duplicated and face a conflict.

### Differences Between Modules and Boxes

**Modules** are "solo", therefore they only publish their very own migrations.

**Boxes** are meant to integrate several submodules, therefore you have 2 options:

1. Publish box's own migrations along with the migrations of all submodules (default)
    ```bash
    php artisan vendor:publish --provider="Vendor\Box\Providers\ModuleServiceProvider" --tag="migrations"  
    ``` 
2. Publish box's own migrations only. To do so, use the tag "own-migrations-only":
    ```bash
    php artisan vendor:publish --provider="Vendor\Box\Providers\ModuleServiceProvider" --tag="own-migrations-only"  
    ``` 
