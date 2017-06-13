# Helpers

Freely based on the idea of Magento helpers. These kinds of classes are
often required in views where using namespaces isn't very elegant, and
pushing instances from controllers would just increase noise.

So Concord's idea is that helpers are generally just services registered
in the service container but they can be reached via an abbreviated call
like `helper('money')->helperMethod()` or if you register the Helper
facade `Helper::get('money')->helperMethod()`.

Helpers instances are singletons.

## Registering Helpers

You can register helpers with Concord's `registerHelper()` method:

```php
concord()->registerHelper('helper_name', HelperClass::class);
```

You can access this helper via `helper('helper_name')->someMethod()`, which gives you short access to `HelperClass`'s `someMethod()`.

> Registering helpers actually adds the class name as a config entry under the `concord.helpers.helper_name` key.


Helpers need to be registered either in a module's `ModuleServiceProvider` or in the `AppServiceProvider` classes `boot()` method:

```php
    public function boot()
    {
        parent::boot();
        
        // In ModuleServiceProviders:
        $this->concord->registerHelper('product', ProductHelper::class);
        // in AppServiceProvider:
        $this->app->concord->registerHelper('product', ProductHelper::class);
    }
```

This makes you possible using `helper('product')->someMethod()`.


#### Next: [Blade Components &raquo;](blade-components.md)