# Concord

_Concord is a Laravel Extension that serves as a foundation to build **Modules for Laravel Applications** on top of Laravel's built in Service Providers._


> **Note**: Concord is still in an early, work-in-progress phase. (Jan 2017).

Concord at first is a Laravel 5.3+ [package](https://laravel.com/docs/5.3/packages) (Service Provicder). Concord also defines a set of rules and recommendations that help you to better
structure complex systems.


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

## Create Your First Module

```
php artisan make:module ShinyModule
```

This will create a very basic in-app module in the `app/Modules/ShinyModule` folder.

In order to activate the module add it to the `config/concord.php` file:

```php
'modules' => [
        App\Module\ShinyModule\Providers\ModuleServiceProvider::class
    ]
```

## Documenatation

See the [documentation](docs/index.md) in the `docs` folder of this repo.