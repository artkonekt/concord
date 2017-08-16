# Migrations

The migrations within Concord are just plain Laravel migrations. Starting with v5.3, Laravel supports migrations distributed in various folders, Concord is utilizing this facility.

Migrations are module and box level parts, since they belong to the model layer, are brothers and sisters with [entities](models.md).

Customizations mostly happen in the application layer, so migrations are naturally present there as well. Application level migrations should contain customizations that are **exclusively relevant** to the specific application/client.

## Turn Migrations On/Off

It is possible to turn on or off migrations in the module configuration setting the `migrations` config value to **false** or **true**:

`ExampleBox/resources/config/box.php`:

```php
<?php
return [
    'modules' => [
        Konekt\Address\Providers\ModuleServiceProvider::class => [
            'migrations' => true
        ],
        Konekt\User\Providers\ModuleServiceProvider::class => [
            'migrations' => false
        ]
    ]
];
```
By default, migrations are published.

**Next**: [Seeds &raquo;](seeds.md)