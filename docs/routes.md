# Routes

Modules should not define routes, boxes are expected to.
An App may or may not want to use routes provided by a box.
Registering of routes therefore can be enabled in the box config very similarly to views.

```php
return [
    'concord' => [
        'loader' => [
            'register' => [
                'routes' => ['web', 'api']
            ]
        ]
    ]
];
```

#### Next: [Resources &raquo;](resources.md)