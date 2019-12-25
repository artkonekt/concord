# Create A Module

## Creating An In-app Module

1. Create the module folder `app/Modules/Demo`
2. Create the file `app/Modules/Demo/Providers/ModuleServiceProvider.php`:

    ```php
    namespace App\Modules\Demo\Providers;
    
    use Konekt\Concord\AbstractModuleServiceProvider;
    
    class ModuleServiceProvider extends AbstractModuleServiceProvider
    {
    }
    ```

3. Create `app/Modules/Demo/resources/manifest.php`:

    ```php
    <?php
    
    return [
        'name'    => 'Demo App Module',
        'version' => '1.3.9'
    ];
    ```

4. Add the module to `config/concord.php`:

    ```php
    <?php
    
    return [
        'modules' => [
            App\Modules\Demo\Providers\ModuleServiceProvider::class,
        ]
    ];
    ```
    
Now if you run the `php artisan concord:modules` command it shows the newly added module:

```
+----+------------------+--------+---------+------+-------------------+
| #  | Name             | Kind   | Version | Id   | Namespace         |
+----+------------------+--------+---------+------+-------------------+
| 1. | Demo App Module  | Module | 1.3.9   | demo | App\Modules\Demo  |
+----+------------------+--------+---------+------+-------------------+
```

## Creating An External Module (With Git And Composer)

1. Init a git repo in an empty folder: `git init .`
2. Add composer.json:

    ```json
    {
        "name": "vendor/mymodule",
        "description": "My Module Rulez",
        "type": "library",
        "require": {
            "php": "^7.2",
            "konekt/concord": "^1.5"
        },
        "autoload": {
            "psr-4": { "Vendor\\MyModule\\": "src/" }
        }
    }
    ```

3. Create the file `src/Providers/ModuleServiceProvider.php`:

    ```php
    namespace Vendor\MyModule\Providers;
    
    use Konekt\Concord\BaseModuleServiceProvider;
    
    class ModuleServiceProvider extends BaseModuleServiceProvider
    {
    }
    ```

4. Create `src/resources/manifest.php`:

    ```php
    <?php
    
    return [
       'name'    => 'My Module',
       'version' => '1.0.0'
    ];
    ```

5. Commit all the stuff, and publish it (github and packagist if it's open source)
6. In the host application: `composer require vendor/mymodule`
7. Add the module to `config/concord.php`:

    ```php
    <?php
    
    return [
       'modules' => [
           Vendor\MyModule\Providers\ModuleServiceProvider::class,
       ]
    ];
    ```

You're done.

**Next**: [Boxes Explained &raquo;](boxes.md)
