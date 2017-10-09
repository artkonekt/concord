# Installation

Add the dependency with composer: `composer require konekt/concord`

#### Register The Provider (Laravel 5.4 Only)

> This step is only necessary for Laravel 5.4. For v5.5+ [Package Auto Discovery](https://laravel.com/docs/5.5/packages#package-discovery) does this automatically.

In the `config/app.php` configuration file, add to the provider array:

```php
'providers' => [
    // Other Service Providers

    Konekt\Concord\ConcordServiceProvider::class,
];
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

**Next**: [Directory Structure &raquo;](directory-structure.md)