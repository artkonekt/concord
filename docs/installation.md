# Installation

Add the dependency with composer: `composer require konekt/concord`

#### Register The Provider

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