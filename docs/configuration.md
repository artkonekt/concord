# Configuration

Basically, the configuration of modules happens the "Laravel way", ie. simple
php files returning arrays, but there are some minor additions.

## Module Config

When listing modules in `config/concord.php` it's possible to set configuration
for that module:

```php
//config/concord.php
return [
  'modules' => [
      // Setting module config:
      Konekt\AppShell\Providers\ModuleServiceProvider::class => [
          'migrations' => false,
          'ui' => [
              'name' => 'Dashboard'              
          ]
      ]
  ]  
];
```

Concord will store these values in the application's configuration, using the
module id as base key:

```php
config('konekt.app_shell.migrations');
// false
config('konekt.app_shell.ui.name');
// "Dashboard"
```

### Concord Specific Configuration

There are several directives with you can influence the module loading:

| Directive  | Default Value | Meaning                                                                                                             |
|:-----------|:--------------|:--------------------------------------------------------------------------------------------------------------------|
| migrations | true          | If false, module's [migrations](migrations.md) won't be published                                                   |
| models     | true          | If false, module's [models](models.md), [enums](enums.md) and [request types](request-types.md) won't be registered |
| views      | true          | If false, module's [views](views.md) won't be available                                                             |
| routes     | true          | If false, module's [routes](routes.md) won't be registered                                                          |

## Using Config Files

Your modules can also use
[package config files](https://laravel.com/docs/5.5/packages#configuration) (in
the app's `config/` folder). This can use the same "namespace" as your module
id, in this case the values will be merged. Or you can use any other name for
the configuration keys, that's completely up to you.

**Example:**

```php
/**
 * config/concord.php:
 */
return [
    'modules' => [
        Vanilo\Cart\Providers\ModuleServiceProvider::class => [
            'routes' => false            
        ]        
    ]
];

/**
 * config/vanilo.php:
 */
return [
    'cart' => [
        'session_key' => 'vaniloCartId'
        
    ]
];
```

Results in:
```php
dump(config('vanilo'));
// array:1 [
//   "cart" => array:6 [
//     "session_key" => "vaniloCartId"
//     "auto_destroy" => false
//     "implicit" => true
//     "migrations" => true
//     "views" => true
//     "routes" => false
//   ]
// ]
```

**Next**: [Migrations &raquo;](migrations.md)
