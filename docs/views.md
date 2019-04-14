# Views

Modules should not define views, and boxes are expected to.
Applications may or may not want to use views provided by boxes.

## Enabling/Disabling Views

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

## Naming Conventions

### Naming View Folders

- Folder names must be all lowercase, eg:
    - `resources/views/order/`
    - `resources/views/product`
- Folder names should be singular nouns, eg. `category/` instead of `categories/`.
- In case the word consists of two parts, dash should be used, eg.: `property-value/`

### Naming View Files

- File names must be all lowercase, eg.: `show.blade.php`
- In case a file is a partial (ie. doesn't extend a layout) the filename must begin with an underscore, eg: `_form.blade.php`
- File names with multiple words should be separated with underscore, eg.: `_form_seo.blade.php`
- File names should follow this resource naming conventions:
    - `show.blade.php` (display a single resource)
    - `index.blade.php` (display a list of resources of a type)
    - `create.blade.php` (the create new entry page)
    - `edit.blade.php` (edit an existing entry page)
    - `_form.blade.php` (the shared form partial for both edit and create)

## Namespace

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


**Next**: [Routes &raquo;](routes.md)

