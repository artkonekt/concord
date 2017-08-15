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