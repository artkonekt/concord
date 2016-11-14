# Create A Module

## Creating An In-app Module

1. Create the module folder `app/Modules/Demo`
2. Create the file `app/Modules/Demo/Providers/ModuleServiceProvider.php`:

    ```php
    <?php
    
    namespace App\Modules\Demo\Providers;
    
    use Konekt\Concord\ModuleServiceProvider as BaseModuleServiceProvider;
    
    class ModuleServiceProvider extends BaseModuleServiceProvider
    {
    }
    ```

3. Create `app/Modules/Demo/resources/mainfest.php`:

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
    
Now if you run the `php artisan concord:list` command it shows the newly added module:

```
+----+-----------------+---------+------------------+
| #  | Name            | Version | Namespace        |
+----+-----------------+---------+------------------+
| 1. | Demo App Module | 1.3.9   | App\Modules\Demo |
+----+-----------------+---------+------------------+
```

#### Next: [Rules &raquo;](rules.md)