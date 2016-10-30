# Module Parts

## Configuration

Following the Laravel convention, these are simple php files returning arrays.

## Entities

Entities are preferably Eloquent models, optionally "aggregated" in the `app/Entities` folder (under `App\Entities` namespace) (? -  to be decided).


The approach is somewhat similar to what Doctrine v1 did use (eg. User extends BaseUser), so the `app/Entities` is rather a proxy folder, which typically extends entity classes defined in modules.

> Proposal: there should be a boolean config setting eg. `concord.entities.collect` that if set, generators(?) will collect and create an overridden version of the entities in the app/Entities folder.

This way apps can easily modify the entities defined by the modules, and they'll be in a single folder

## Controllers

A module can ship with predefined controllers, and they can be used directly or via routes.

In case an app wants to extend a module's controller AND wants to use the module's built in routes, it should do the following thing:

- The module controllers should specified in routes via interfaces (`Contracts` folder)
- Laravel's dynamic class loader is able to resolve classes
- In case the app wants to use a different implementation, it has to bind another implementation to that interface:

```php
    $this->app->bind(
        'ExampleModule\Contracts\ExampleController',
        'App\Concord\ExampleModule\Controllers\ExampleController'
    );
```

## Middlewares

## Events And Listeners

Events and listeners can be defined either by modules or the application itself.
Modules define their default event-listener bindings in their own `Providers/EventServiceProvider.php` file.

An app however, may want to override these bindings.

As an example a forum module defines that a `CommentWasPosted` event is being listened by `SendEmailToThreadSubscribers` and `IncreaseUserPostCount` listeners.
But the implementing app may want to omit sending these emails, so they can override these module bindings.

So in case you want the module loader to register the module's EventServiceProvider (which it doesn't do by default) you should add this to the module's config file:

```php
return [
    'concord' => [
        'loader' => [
            'register' => [
                'events_provider' => true
            ]
        ]
    ]
];
```

## Routes

You may or may not want to use routes provided by the module.
Registering of routes therefore can be enabled in the module config

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

## Views

You may or may not want to use views provided by the module.
Registering of views can be enabled in the module config very similarly to routes

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

## Helpers

Freely based on the idea of Magento helpers. These kinds of classes are
often required in views where using namespaces isn't very elegant, and
pushing instances from controllers would just increase noise.

So Concord's idea is that helpers are generally just services registered
in the service container but they can be reached via an abbreviated call
like `helper('money')->helperMethod()` or if you register the Helper
facade `Helper::get('money')->helperMethod()`.
