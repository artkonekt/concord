# Conventions

Concord's [directory layout](directory-structure.md) is actually just a nice default that can be customized if you don't like it.

## Custom Layout

1. Study the `ConcordDefault` class in the `src/Convetions` folder
2. Create your own convention class that implements the `Konekt\Concord\Contracts\Convention` interface
3. Set the convention class in the `concord.php` config file:
    ```php
    return [
        'convention' => App\MyConvention::class,
        'modules' => [
            //...
        ],
        
    ];
    ```