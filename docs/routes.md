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
            'routes' => true, // register all routes in the folder (*.php) 
            'routes' => false // don't register any routes
        ]
    ]
];
```
All routes will be included in a [route group](https://laravel.com/docs/5.8/routing#route-groups) whose parameters can also be configured:

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

To register routes with different settings (**v1.3+**):

```php
return [
    'modules' => [
        Vendor\MyBox\Providers\BoxServiceProvider::class => [
            'routes' => [
                [
                    'files'     => ['acl'],
                    'prefix'    => '/admin',
                    'as'        => 'admin.',
                    'middleware'=> ['web', 'auth', 'acl']
                ],
                [
                    'files'     => ['nonacl'],
                    'prefix'    => '/admin',
                    'as'        => 'admin.',
                    'middleware'=> ['web', 'auth']
                ]
            ]
        ]
    ]
];
```

**Next**: [Resources &raquo;](resources.md)
