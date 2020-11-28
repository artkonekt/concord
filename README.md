# Concord

_Concord is a Laravel Extension that helps building **Modules for Laravel Applications** on top of Laravel's built in Service Providers._

[![Travis](https://img.shields.io/travis/com/artkonekt/concord.svg?style=flat-square)](https://travis-ci.com/artkonekt/concord)
[![Packagist version](https://img.shields.io/packagist/v/konekt/concord.svg?style=flat-square)](https://packagist.org/packages/konekt/concord)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/concord.svg?style=flat-square)](https://packagist.org/packages/konekt/concord)
[![StyleCI](https://styleci.io/repos/65661796/shield?branch=master)](https://styleci.io/repos/65661796)
[![Code Quality](https://img.shields.io/scrutinizer/quality/g/artkonekt/concord?style=flat-square)](https://scrutinizer-ci.com/g/artkonekt/concord/)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Concord at first is a Laravel 6.x - 8.x
[package](https://laravel.com/docs/8.x/packages). It also offers some
conventions that help you to better structure complex systems.

## Version Compatibility

| Laravel | Concord   |
|:--------|:----------|
| 5.4     | 1.0 - 1.3 |
| 5.5     | 1.0 - 1.8 |
| 5.6     | 1.1 - 1.8 |
| 5.7     | 1.3 - 1.8 |
| 5.8     | 1.3 - 1.8 |
| 6.x     | 1.4+      |
| 7.x     | 1.5+      |
| 8.x     | 1.8+      |

## Basics

> Modular Architecture is exactly what you think it is - a way to manage the
> complexity of a problem by breaking them down to smaller manageable modules.
> -- [Param Rengaiah](https://medium.com/on-software-architecture/on-modular-architectures-53ec61f88ff4)

Concord itself (this library) manages the modules.

Concord [modules](https://konekt.dev/concord/1.8/modules) are isolated
fractions of the business logic, built around a single topic.

There are two kinds of modules from the usage perspective:

- in-app modules,
- external modules.

Concord is not aware of this difference at all, but they represent two different
approaches of modularization.


### In-app Modules

- They are part of the application's codebase;
- are located in `app/Modules/<ModuleName>`;
- being decoupled is a less strict requirement;
- code reuse and customization is not an aspect.

### External Modules

- They are libraries,
- are typically managed with composer, thus they live in the `vendor/` folder;
- should be as decoupled as possible;
- contain basic or boilerplate functionality for applications;
- they are designed to be used by multiple, different applications;
- their behavior is subject to customization in the application.

Either module types are always coupled to Laravel and Concord;

## Installation

Refer to the [Installation Section](https://konekt.dev/concord/1.8/installation) of the Documentation.

## Create Your First Module

```
php artisan make:module ShinyModule
```

This will create a very basic in-app module in the `app/Modules/ShinyModule` folder.

In order to activate the module add it to the `config/concord.php` file:

```php
return [
    'modules' => [
        App\Modules\ShinyModule\Providers\ModuleServiceProvider::class
    ]
];
```

## Documenatation

See the [Concord Documentation](https://konekt.dev/concord/1.4) for all the
nasty details ;)

## Plans For Version 2.0

- Artisan Console command names will be de-branded (eg. `concord:modules` -> `module:list`)
- The central `config/concord.php` file will be eliminated, or split:
    - modules can specify their own config file name (like normal Laravel packages);
    - therefore several modules can share config files (see vanilo.php);
    - if we keep concord.php, then it'll contain concord specific settings.
- Modules will be loaded as normal packages, using auto-discovery instead of listing modules with concord.
- Custom names for service providers eg. CartServiceProvider instead of ModuleServiceProvider.
- Question to the prior item is how to do the same with in-app modules.
- Re-think the concept of boxes vs. modules.
- Remove surplus items from Documentation.
- Remove helpers (?).
- Remove custom view namespace support.
- Will we ever use Controller overriding?
- Add make:request, make:model, make:enum commands that scaffold with interface, proxy etc.
- Fix AddressType -> address_type kind of style problem in route parameters
- 
