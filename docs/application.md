# Concord Applications

A Concord application is nothing but any Laravel application that uses the concord service provider and loads at least one concord module (or box).

This app may or may not comply with all the concord rules.

## Setup

Setting up a Laravel app for concord is simple:

1. Install the package via composer `composer require konekt/concord`
2. Register The Provider: `config/app.php` add:
    ```php
    'providers' => [
        // Other Service Providers
    
        Konekt\Concord\ConcordServiceProvider::class,
    ]
    ```
3. Publish The Config File: `php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config`

It's done, you can start adding modules/boxes to your app.

#### Next: [Modules Explained &raquo;](modules.md)
