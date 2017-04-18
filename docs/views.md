# Views

Modules should not define views, and boxes are expected to.
Applications may or may not want to use views provided by boxes.
Registering of views can be enabled/disabled in the box config

```php
<?php

return [
    'modules' => [
        Vendor\MyModule\Providers\ModuleServiceProvider::class => [
            'views' => false
        ]
    ]
];
```

#### Next: [Routes &raquo;](routes.md)