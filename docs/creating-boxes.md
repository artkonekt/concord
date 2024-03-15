# Creating Boxes

> Compared to Modules there's not much sense to create an in-app box, even if it's technically possible. The reason is that a Box can be considered an application boilerplate, so why define a template and immediately overwrite it? Your application is responsible for everything an in-app Box would do.

## Creating An External Box (With Git And Composer)

1. Init a git repo in an empty folder: `git init .`
2. Add composer.json:

    ```json
    {
        "name": "vendor/mybox",
        "description": "My Box Rulez",
        "type": "library",
        "require": {
            "php": ">=7.0.0",
            "konekt/concord": ">=0.9.10"
        },
        "autoload": {
            "psr-4": { "Vendor\\MyBox\\": "src/" }
        }
    }
    ```

3. Create the file `src/Providers/ModuleServiceProvider.php`:

    ```php
    namespace Vendor\MyBox\Providers;
    
    use Konekt\Concord\BaseBoxServiceProvider;
    
    class ModuleServiceProvider extends BaseBoxServiceProvider
    {
    }
    ```

4. Create `src/resources/manifest.php`:

    ```php
    <?php
    
    return [
       'name'    => 'My Box',
       'version' => '1.0.0'
    ];
    ```

5. Commit all the stuff, and publish it (github and packagist if it's open source)

## Adding Modules To The Box

Boxes have their primary config file located in `resources/config/box.php`.
Modules need to be added here:

```php
<?php

return [
    'modules' => [
        Vendor\MyModule\Providers\ModuleServiceProvider::class => [],
        Vendor\AnotherModule\Providers\ModuleServiceProvider::class => []
    ]
];
```

The empty arrays in the example mean that everything from those modules will be imported according to the defaults.

### Overriding Module Parts

#### Suppressing Migrations

You may decide to gather/modify/skip migrations from the underlying modules. In this case you can suppress migrations provided by the module:

```php
<?php

return [
    'modules' => [
        Vendor\MyModule\Providers\ModuleServiceProvider::class => [
            'migrations' => false    
        ],
        Vendor\AnotherModule\Providers\ModuleServiceProvider::class => [
            'migrations' => false            
        ]
    ]
];
```

> See also: [Box Configuration](configuration.md#box-configuration)
> and [Turn Migrations On/Off](migrations.md#turn-migrations-onoff)

!> Make sure to provide a compatible replacement if you're suppressing a module's migration.

## Adding A Box To An Application

1. In the laravel application: `composer require vendor/mybox`
2. Add the module to `config/concord.php`:

    ```php
    <?php
    
    return [
       'modules' => [
           Vendor\MyBox\Providers\ModuleServiceProvider::class,
       ]
    ];
    ```

**Next**: [Configuration &raquo;](configuration.md)
