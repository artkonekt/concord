# Parts

## Configuration

Following the Laravel convention, these are simple php files returning arrays.

## Migrations

Migrations.

## Entities

Entities are Eloquent models, optionally "aggregated" in the `app/Entities` folder (under `App\Entities` namespace) (? -  to be decided).

The approach is somewhat similar to what Doctrine v1 did use (eg. User extends BaseUser), so the `app/Entities` is rather a proxy folder, which typically extends entity classes defined in modules.

> Proposal: there should be a boolean config setting eg. `concord.entities.collect` that if set, generators(?) will collect and create an overridden version of the entities in the app/Entities folder.

This way apps can easily modify the entities defined by the modules, and they'll be in a single folder

## Repositories

Concord Repositories are [collection oriented](http://shawnmc.cool/the-repository-pattern#collection-oriented-vs-persistence-oriented),
thus only to be used for data retrieval; persistence (store, update, delete) should be done directly via the model.

Use of [query scopes](https://laravel.com/docs/5.3/eloquent#query-scopes) is encouraged, repositories should wrap them.

## Events

Events should be defined on module level, but it is allowed define them on higher levels (box, app).

## Listeners

Listeners should not be defined on module level, they are expected to be defined on box or app level.

## Event-Listener Bindings

Modules must not bind events to listeners. Boxes and apps are expected to do so.
[Details](parts-event-listener-bindings.md)

## Helpers

Freely based on the idea of Magento helpers. These kinds of classes are
often required in views where using namespaces isn't very elegant, and
pushing instances from controllers would just increase noise.

So Concord's idea is that helpers are generally just services registered
in the service container but they can be reached via an abbreviated call
like `helper('money')->helperMethod()` or if you register the Helper
facade `Helper::get('money')->helperMethod()`.

## Blade Components

> **Warning**: This is a Laravel 5.4 feature!

Modules must not define views, however they can define blade components that act as "view templates" to be reused on higher levels.

## Views

Modules must not define views, and boxes are expected to.
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

## Routes

Modules must not define routes, boxes are expected to.
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

## Resources

Resources (assets, sass, js, lang files, etc) belong to boxes and applications.

## Controllers

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

## Commands

Commands; box or app level.

## Middlewares

Middlewares; box or app level.

## Request Types

Request types (form types); box or app level.

## Notifications

Laravel notifications; box or app level.

