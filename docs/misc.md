# Misc Functions

Concord contains several helper functions that can be used by applications as well.

## classpath_to_slug()

This function converts a fully qualified classname to a string, backslashes to dots, parts to snake case:

```php
classpath_to_slug(App\Providers\AppServiceProvider::class);
// => 'app.providers.app_service_provider'
```

## slug_to_classpath()

Counterpart of classpath_to_slug, that converts the string back to a fully qualified classname.

```php
slug_to_classpath('app.providers.app_service_provider');
// => 'App\Providers\AppServiceProvider' 
```

## morph_type_of()

This function is essentially the inverse of `Relation::getMorphedModel($alias)`.

It retrieves the relation alias if it was registered with
`Relation::morphMap(['alias' => Model::class])` or the classname itself if no alias
exists.

It accepts both classnames and objects.

```php
Relation::morphMap([
    'invoice' => Invoice::class,
    'return_slip' => ReturnSlip::class,
]);

morph_type_of(Invoice::class));
// 'invoice'

morph_type_of(new ReturnSlip()));
// 'return_slip'

morph_type_of(App\Models\Customer::class));
// 'App\Models\Customer'

morph_type_of(new App\Models\Customer());
// 'App\Models\Customer'
```

**Next**: [Concord Events &raquo;](concord-events.md)
