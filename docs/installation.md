# Installation

## Version Compatibility

| Laravel | Concord   |
|:--------|:----------|
| 5.4     | 1.0 - 1.3 |
| 5.5     | 1.0+      |
| 5.6     | 1.1+      |
| 5.7     | 1.3+      |
| 5.8     | 1.3+      |
| 6.x     | 1.4+      |

## Installing Concord with Composer

1. Add the dependency with composer: `composer require konekt/concord`
2. Publish the config file:
    ```bash
    php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config
    ```

**Next**: [Directory Structure &raquo;](directory-structure.md)
