# Concord

> **Note**: This is a very early draft version of the Concord spec, it is about to change a lot.

Concord is a set of rules and contracts that establishes a modular business application framework on top of Laravel.

It is **NOT** an MVC framework but an extension on top of Laravel 5.3+

## Main Goals

- Provide an extensible PHP platform for business applications
- Provide a system for using/creating a plugin-like modular architecture
- Have a system that can embrace decoupled modules, so that we can get rid of duplications across projects
- Use all the goodness and best practices of Laravel 5.3+
- Standardize entities and their related design patterns (repositories, factories, etc)
- DDD but ActiveRecord :)
- Establish a framework where specific modules can be customized, or even replaced
- Avoid over-engineering
- Keep the developer's liberty so that it's not a nightmare to implement/customize things

## Inspirations

- [Symfony Bundles](http://symfony.com/doc/bundles/)
- [Sylius Resource Component](https://github.com/Sylius/Resource)
- [Creating a Modular Application in Laravel 5.1](http://kamranahmed.info/blog/2015/12/03/creating-a-modular-application-in-laravel/)
- [Modular Structure in Laravel 5](https://ziyahanalbeniz.blogspot.ro/2015/03/modular-structure-in-laravel-5.html)
- [Caffeinated Modules](https://github.com/caffeinated/modules)
- [Caffeinated Presenters](https://github.com/caffeinated/presenter)
- [Caffeinated Themes](https://github.com/caffeinated/themes)
- [Caffeinated Repository](https://github.com/caffeinated/repository)
- https://github.com/creolab/laravel-modules

## Installation

#### With Composer

Add the dependency to composer: `composer require konekt/concord`

#### Register The Provider

In the `config/app.php` configuration file, add to the provider array:

```php
'providers' => [
    // Other Service Providers

    Konekt\Concord\ConcordServiceProvider::class,
]
```

#### Publish The Config File

```
php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config
```

## Application

Any application can be a Concord compliant application that complies with its rules.
The application can define it's own logic and/or incorporate Concord compliant modules.

## Modules

Modules are the actual implementations of the business logic and they have to comply with Concord's rules in order to be able to cooperate as a unified business application.

Modules are usually decoupled components as separate composer packages, and are glued together by the Concorde compliant application.

### Module Folder Structure

#### Minimum Fileset For A Concord Module

```
module-src/
    Providers/
        |-- ModuleServiceProvider.php
    resources/
        |-- config/
            |-- module.php
        |-- manifest.php
    
```

#### Full Stack Of Recommended File/Folder Structure
 
```
module-src/
    Console/
    Contracts/
    Events/
    Exceptions/
    Http/
        |-- Controllers/
        |-- Middleware/
        |-- Requests/
    Jobs/
    Listeners/
    Models/
        |-- Entities/
        |-- Repositories/
    Providers/
        |-- ModuleServiceProvider.php
        |-- EventServiceProvider.php
    Services/
    resources/
        |-- config/
            |-- module.php
        |-- database/
            |-- migrations/
            |-- seeds/
        |-- lang/
        |-- public/
            |-- assets/
        |-- routes/
            |-- api.php
            |-- web.php
        |-- views/
        |-- manifest.php
    
```

## Building Blocks

### Configuration

Following the Laravel convention, these are simple php files returning arrays.

### Entities

Entities are Eloquent models, and are "aggregated" in the `app/Entities` folder (under `App\Entities` namespace).

The approach is somewhat similar to what Doctrine v1 did use (eg. User extends BaseUser), so the `app/Entities` is rather a proxy folder, which typically extends entity classes defined in modules.

This way apps can modify the entities defined by the modules.

### Controllers

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

### Middlewares

### Events And Listeners

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

### Routes

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

### Views

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