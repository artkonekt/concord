# Views

Modules should not define views, and boxes are expected to.
Applications may or may not want to use views provided by boxes.

### Enabling/Disabling Views

Registering of views can be enabled/disabled in the box config:


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
### Namespace

Namespace can also be set explicitely for view folder to be used as

```php
<?php

return [
    'modules' => [
        Vendor\SuperBox\Providers\BoxServiceProvider::class => [
                    'views' => [
                        'namespace' => 'super'    
                    ]
                ]
    ]
];
```

and then use it as:

```blade
    @include('super::folder.viewfile')
```

If not specified explicitely, default namespace is the module's folder name converted to snake case, eg.: `Vendor\SuperBox` => 'super_box'


#### Next: [Routes &raquo;](routes.md)