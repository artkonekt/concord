# Short Names

Models, Enums & Requests registered with Concord can also be accessed by their short names.

Short name is the class's base name converted to snake case:

| Full Class Name                       | Short Name   |
|---------------------------------------|--------------|
| Konekt\Address\Contracts\AddressType  | address_type |
| Konekt\Address\Contracts\Gender       | gender       |
| App\Modules\Booking\Models\BedType    | bed_type     |

You can access the abstract class name (usually the interface) with concord by using it's `short()` method:

```php
concord()->short('gender');// Returns "Konekt\Address\Contracts\Gender"
```

[Enums](enums.md) can be accessed directly with the `enum()` globally available helper function:

```php
enum('gender')->choices();
//=> [
//     "m" => "Male",
//     "f" => "Female",
//   ]
```

**Next**: [Proxies &raquo;](proxies.md)
