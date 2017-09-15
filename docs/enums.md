# Enums

Concord internally uses the [konekt enum](https://github.com/artkonekt/enum) library, so enums are available when using Concord.

Other than what the library provides out of the box, Concord also gives some nice additions to enums.

## Registering Enums

Enums provided by modules need to be registered with Concord in order to use its utilities.

Registering can be done in the module/box service provider, by adding the enum class's name to the `$enums` protected property:

```php
// ModuleServiceProvider.php

namespace App\Modules\Booking\Providers;

use App\Modules\Booking\Models\BedType;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $enums = [
        BedType::class
    ];
}
```

## Extending Enums

In case you want to extend an enum that was registered by another module these are the steps to do so:

1. Extend the class
2. Define new const values
3. Register your class with Concord for the Enum's interface

**Example:**

```php
// The original enum class in an underlying module:
namespace Vendor\Module\Models;

class OriginalEnum extends \Konekt\Enum\Enum
{
    const FUBANG = 'fubang';
    const ZDOINK = 'zdoink';
}
```

```php
// Extend the class and define new const values
namespace App;

class YourEnum extends \Vendor\Module\Models\OriginalEnum
{
    const SPLASH  = 'splash';
}
```
Register with concord:
```php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->concord->registerEnum(
            \Vendor\Module\Contracts\OriginalEnum::class,
            \App\YourEnum::class
        );
    }
}
```

This way:
1. all the underlying models using the original enum will use your enum instead
2. The enum proxy will resolve to your enum class.

```php
use Vendor\Module\Models\OriginalEnumProxy;

echo OriginalEnumProxy::enumClass();
// output: App\YourEnum

$fubang = OriginalEnumProxy::create('fubang');

echo get_class($fubang);
// output: App\YourEnum
echo $fubang->value();
// output: fubang

$splash = OriginalEnumProxy::create('splash');
echo $splash->value();
// output: splash
```

## Enum Proxies

Using this technique you can define the basic variant of your enum in your module and it can be extended later.

## Enum Helper Function

It's possible to resolve enums with their [short names](short-names.md) via the `enum()` helper function.

It's mainly useful in blade or other templates that you don't want to mess up with long, fully qualified classnames:

```blade
<select>
    @foreach(enum('bed_type')->choices as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
```

It's also possible to provide the value of the enum:
```php
$male = enum('gender', 'm');
```

**Next**: [Events &raquo;](https://github.com/artkonekt/concord/blob/master/docs/events.md)