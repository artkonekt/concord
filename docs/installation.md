# Installation

## Version Compatibility

| Laravel | Concord    |
|:--------|:-----------|
| 5.4     | 1.0 - 1.3  |
| 5.5     | 1.0 - 1.8  |
| 5.6     | 1.1 - 1.8  |
| 5.7     | 1.3 - 1.8  |
| 5.8     | 1.3 - 1.8  |
| 6.x     | 1.4 - 1.10 |
| 7.x     | 1.5 - 1.10 |
| 8.x     | 1.8 - 1.11 |
| 9.x     | 1.10.2+    |
| 10.x    | 1.13+      |
| 11.x    | 1.14+      |

## Installing Concord with Composer

1. Add the dependency with composer: `composer require konekt/concord`
2. Publish the config file:
    ```bash
    php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config
    ```

**Next**: [Directory Structure &raquo;](directory-structure.md)
