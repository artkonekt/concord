# Routes

Modules should not define routes, boxes are expected to.
An App may or may not want to use routes provided by a box.
Registering of routes therefore can be enabled in the box config very similarly to views.

```php
return [
    'modules' => [
        Vendor\MyBox\Providers\BoxServiceProvider::class => [
            'routes' => [
                'files'=> ['web', 'api']
            ], // register specific routes
            'routes' => true, // register all routes provided
            'routes' => false // don't register any routes
        ]
    ]
];
```
All routes will be included in a [route group](https://laravel.com/docs/5.4/routing#route-groups) whose parameters can also be configured:

```php
return [
    'modules' => [
        Vendor\MyBox\Providers\BoxServiceProvider::class => [
            'routes' => [
                'files'     => ['web', 'api'],
                'namespace' => 'Name\\Space\\Here', // Defaults to the module's route namespace
                'prefix'    => 'url_prefix', // Defaults to the module's short name
                'as'        => 'route.prefix.', // default is module's short name and a dot ('.') at the end
                'middleware'=> ['web', 'auth', 'acl'] // defaults to ['web']
            ]
        ]
    ]
];
```

**Next**: [Resources &raquo;](resources.md)