# Routes

Modules should not define routes, boxes are expected to.
An App may or may not want to use routes provided by a box.
Registering of routes therefore can be enabled in the box config very similarly to views.

```php
<?php

return [
    'modules' => [
        Vendor\MyBox\Providers\BoxServiceProvider::class => [
            'routes' => ['web', 'api'], // register specific routes
            'routes' => true, // register all routes provided
            'routes' => false // don't register any routes
        ]
    ]
];
```

**Next**: [Resources &raquo;](resources.md)