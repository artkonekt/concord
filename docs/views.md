# Views

Modules should not define views, and boxes are expected to.
Applications may or may not want to use views provided by boxes.
Registering of views can be enabled in the box config

```php
return [
    'concord' => [
        'loader' => [
            'register' => [
                'views' => true
            ]
        ]
    ]
];
```

#### Next: [Routes &raquo;](routes.md)