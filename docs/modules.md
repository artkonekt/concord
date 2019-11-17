# Concord Modules

Modules are decoupled components and are glued together by the
[application](application.md) (or by a [box](boxes.md)). Technically they're a
bunch of classes and files wired into the Laravel Application with their own
dedicated [Service Provider](https://laravel.com/docs/5.8/providers).

Modules can be situated in two ways:

- as external modules (separate composer packages)
- in-app modules (usually under `app/Modules/<ModuleName>`)

Technically there's no difference between the two.


## Module Folder Structure

#### Minimum Fileset For A Concord Module

```
module-src/
    Providers/
        |-- ModuleServiceProvider.php
    resources/
        |-- manifest.php
    
```

#### Full Stack Of Recommended File/Folder Structure

```
module-src/
    Contracts/
    Events/
    Exceptions/
    Helpers/
    Models/
        |-- Factories/
    Providers/
        |-- ModuleServiceProvider.php
    Services/
    Tests/
        |-- Feature
        |-- Unit
    resources/
        |-- config/
            |-- module.php
        |-- database/
            |-- migrations/
            |-- seeds/
        |-- manifest.php
    
```

## Module Id

Concord automatically calculates the module id based on the module's namespace.

**Examples:**

| Namespace                                     | Module Id      | Type     |
|:----------------------------------------------|:---------------|:---------|
| App\Modules\Billing                           | billing        | in-app   |
| App\Modules\Analytics                         | analytics      | in-app   |
| App\Modules\ClientHistory                     | client_history | in-app   |
| Vendor\Module\Providers\ModuleServiceProvider | vendor.module  | external |
| Vanilo\Cart\Providers\ModuleServiceProvider   | vanilo.cart    | external |
| Vanilo\Order\Providers\ModuleServiceProvider  | vanilo.order   | external |
| Konekt\Acl\Providers\ModuleServiceProvider    | konekt.acl     | external |

### Retrieve Modules From Concord By ID:

**Using the facade:**

```php
use Konekt\Concord\Facades\Concord;

$cartModule = Concord::module('vanilo.cart');
```

**Using the service from the container:**

```php
$billingModule = app('concord')->module('billing');

// or if you have an app instance available:
$billingModule = $this->app['concord']->module('billing');
```

**Next**: [Creating Modules &raquo;](creating-modules.md)
