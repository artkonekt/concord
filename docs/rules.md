# Concord Rules

## Mandatory Rules

1. Both the application and modules must be PSR-0 or PSR-4 compliant.
2. Applications must load the concord service provider.
3. Modules must contain a `<ModuleNameSpace>\Providers\ModuleServiceProvider` class that extends `Konekt\Concord\ModuleServiceProvider`
4. Modules must contain a `resources/mainfest.php` file that returns at least these
    ```php
    return [
        'name'    => 'The module name',
        'version' => 'semantic version string'
    ];
    ```

## Optional Rules

1. Modules should define configuration files
2. Module services should be defined via interfaces instead of string based names. Eg. `VendorX\ModuleY\Contracts\FooRepositoryInterface` instead of `moduley.fooreposoitory`. (_The latter is prevalent in the Symfony world, but it has no direct binding on the code level. Laravel's container supports both of these, Concord recommends the interface variant._)
3. Modules should do controller bindings via interfaces in their routes definition
4. Modules should use Eloquent models
5. Apps should aggregate all entities (Eloquent models) from the models in `app/Entities` folder by extending their classes, eg.:
    ```php
    namespace App\Entities;

    class Product extends VendorName\ExampleModule\Models\Entities\Product
    {
        //It's ok if it's completely empty
    }
    ```

## Modules Have To Be Aware Of

1. Apps may or may not use their [parts](parts.md)
2. Eloquent models are subject to customization in the host app
3. Event and Listener classes are visible to apps, but their bindings defined by the module might be ignored by the host app.

#### Next: [Parts &raquo;](parts.md)