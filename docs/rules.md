# Rules & Recommendations

Concord intends to keep the number of their constraints as low as possible, so
that you can keep working your way.

## Mandatory Rules

1. Both the application and modules must be [PSR-4](https://laravel.com/docs/5.4/releases#laravel-5.0) compliant.
2. Applications must load the concord service provider.
3. Modules must contain a `<ModuleNameSpace>\Providers\ModuleServiceProvider` class that extends `Konekt\Concord\BaseModuleServiceProvider`
4. Modules must contain a `resources/mainfest.php` file that returns at least these:

    ```php
    return [
        'name'    => 'The module name',
        'version' => 'version string'
    ];
    ```

## Recommendations

1. Modules should define configuration files
2. Module services should be defined via interfaces instead of string based
   names. Eg. `Vendor\CoolModule\Contracts\OrderNumberGenerator` instead of
   `cool_module.order_number_generator`. (_The latter is prevalent in the
   Symfony world, but it has no direct binding on the code level. Laravel's
   container supports both of these, Concord recommends the interface variant
   wherever it's possible and reasonable._)
3. Modules should use Eloquent models

## External Modules Have To Be Aware Of

1. Apps may or may not use their [parts](map.md);
2. Eloquent models are subject to customization in the host app;
3. Event and Listener classes are visible to apps, but their bindings defined by
   the module might be ignored by the host app.

**Next**: [Application &raquo;](application.md)
