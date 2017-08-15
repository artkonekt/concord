# Controllers

A box can ship with predefined controllers, and they can be used directly or via routes.

In case an app wants to extend a boxes controller AND wants to use the boxes built in routes, it should do the following thing:

- The box controllers should specified in routes via interfaces (`Contracts` folder)
- Laravel's dynamic class loader is able to resolve classes
- In case the app wants to use a different implementation, it has to bind another implementation to that interface:

```php
    $this->app->bind(
        'ExampleBox\Contracts\ExampleController',
        'App\Concord\ExampleBox\Controllers\ExampleController'
    );
```

**Next**: [Commands &raquo;](commands.md)