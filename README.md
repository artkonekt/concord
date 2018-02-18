# Concord

_Concord is a Laravel Extension that helps building **Modules for Laravel Applications** on top of Laravel's built in Service Providers._

[![Travis](https://img.shields.io/travis/artkonekt/concord.svg?style=flat-square)](https://travis-ci.org/artkonekt/concord)
[![Packagist version](https://img.shields.io/packagist/v/konekt/concord.svg?style=flat-square)](https://packagist.org/packages/konekt/concord)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/concord.svg?style=flat-square)](https://packagist.org/packages/konekt/concord)
[![StyleCI](https://styleci.io/repos/65661796/shield?branch=master)](https://styleci.io/repos/65661796)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Concord at first is a Laravel 5.4+
[package](https://laravel.com/docs/5.4/packages). It also offers some
conventions that help you to better structure complex systems.

> Laravel 5.6 is supported from v1.1.0 upwards

## Basics

> Modular Architecture is exactly what you think it is - a way to manage the
> complexity of a problem by breaking them down to smaller manageable modules.
> -- [Param Rengaiah](https://medium.com/on-software-architecture/on-modular-architectures-53ec61f88ff4)

Concord itself (this library) manages the modules.

Concord [modules](https://artkonekt.github.io/concord/#/modules) are isolated
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

Refer to the [Installation Section](https://artkonekt.github.io/concord/#/installation) of the Documentation.

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

See the [Concord Documentation](https://artkonekt.github.io/concord) for all the
nasty details ;)
