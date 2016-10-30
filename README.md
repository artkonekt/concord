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

Optionally, you can register facade aliases in `config/app.php`:

```php
'aliases' => [
    // ...
    'Concord' => Konekt\Concord\Facades\Concord::class,
    'Helper'  => Konekt\Concord\Facades\Helper::class,
],
```

#### Publish The Config File

```
php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config
```

## Documenatation

See the [documentation](docs/index.md) in the `docs` folder of this repo.