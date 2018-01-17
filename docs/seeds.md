# Seeders

Seeders are just normal [Laravel seeders](https://laravel.com/docs/5.5/seeding). The default (recommended) folder for db seeds is `<module_root>/resources/database/seeds`

The only difference compared to seeders placed in your project's `database/seeds` folder is that app seeders use no namespace.

## Possible Solutions For Class Autoloading

### Use Nice Namespaces (Best)

1. Put your seeder class in the `resources/database/seeds` folder.
2. Use namespace `Vendor\Module\Seeds`.
3. Add the namespace in composer.json:
```json
"autoload": {
    "psr-4": {
        "Vendor\\Module\\": "src",
        "Vendor\\Module\\Seeds\\": "src/resources/database/seeds"
    }
}
```

Then you can either added the seeder to the main `DatabaseSeeder`'s run method `$this->call(\Vendor\Module\Seeds\YourSeeder::class)` or invoke explicitly with artisan:

```bash
php artisan db:seed --class="\Vendor\Module\Seeds\YourSeeder"
```

### Use Ugly Namespaces (Easy)

1. Put your seeder class in the `resources/database/seeds` folder.
2. Use namespace `Vendor\Module\resources\database\seeds`.

Adding to app's main the seeder:
```php
class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $this->call(\Vendor\Module\resources\database\seeds\YourSeeder::class);        
    }
}
```

Invoking with artisan:
```bash
php artisan db:seed --class="\Vendor\Module\resources\database\seeds\YourSeeder"
```

### Use No Namespace (Simple)

If you're sure you won't conflict with other seeders having the same name, then you can go without seeders having namespaces.

1. Put your seeder class in the `resources/database/seeds` folder.
2. Use a composer json like this:
```json
"autoload": {
    "classmap": [
        "src/resources/database/seeds"    
    ],
    "psr-4": {
        "Vendor\\Module\\": "src"
    }
}
```

Adding to DatabaseSeeder `$this->call(YourSeeder::class);`

Invoking explicitely with artisan:
```bash
php artisan db:seed --class=YourSeeder
```

**Next**: [Models (Entities) &raquo;](models.md)
