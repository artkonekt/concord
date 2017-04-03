# Entities (Eloquent Models)

Entities are the *nouns* in your system (like product, order, customer, subscription, etc). Concord being a disciplined Laravel citizen uses Eloquent models for that. Yes, Active Record with all its goodies and curses.

## Preface

As Concord has been created for flexible, modular, "pluginizable" architecture, **it's inevitable to have additional complexity** compared to standalone Laravel applications.

One of the essential goals of Concord is to support creating **reusable code** for Laravel applications. As an example you can create yourself or use a 3rd party [module](modules.md) for managing products. You pull that module in your application with composer and consider that module as **immutable** (indifferent whether it's your own creation or third party).

> Did you notice that this is a real life use case of [SOLID's *open-close* principle](https://en.wikipedia.org/wiki/Open/closed_principle)?

The **product module** is a *lower* layer and your **application** is an *upper* layer. This document discusses both perspectives:

- How to author reusable modules (ie coding the lower layer);
- How to extend modules in your application.

Obviously a module is only immutable from the application's perspective. As a module author you definitely want to evolve your module.

Thus another essential feature is that you want to **be able to update the underlying modules in your application** without breaking your code. (Two words: [Semantic Versioning](http://semver.org/))

From the Entities perspective our goal is to outsource basic functionality in modules, ie having basic versions of our *nouns* ready to be customized by the application. For this goal we need a well defined path for extending/overriding Eloquent model classes defined in *lower layers* (module).

## Overriding Entites (Models)

[For tl;dr click here](#the-solution)

### The Problem

In our interpretation, good platforms:

- provide the essential functionality out of the box, and
- make it easy to customize their basic behavior.

As an example there is the `Product` model. It's defined in a *lower* layer, in the product **module**. *Upper* layers, like the final **application** will want to alter/extend it so that it doesn't break the basic functionality the module. At its heart, that's what OOP is for. Is it that simple?

### Possible Entity Modifications

You'll be guided through an example, that demonstrates the possible modifications of an entity across layers.

Say whe have a **product** module, that contains the `Product` class (an eloquent model) which has the following attributes (fields):

- id
- sku
- title
- status (draft, active, retired)
- price
- description

With Eloquent, you can get fields like `$product->sku`, `$product->title`, etc.

You can make the status field typed by using an [enum](https://github.com/artkonekt/enum) and Eloquent's [accessors & mutators](https://laravel.com/docs/5.4/eloquent-mutators):

The enum class:
```php

use Konekt\Enum\Enum;

class ProductStatus extends Enum
{
    const __default   = self::DRAFT;
    
    const DRAFT       = 'draft';
    const ACTIVE      = 'active';
    const RETIRED     = 'retired';
}
```

Accessor/Mutator:
```php
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @return ProductStatus
     */
    public function getStatusAttribute()
    {
        return new ProductStatus($this->attributes['status']);
    }
    
    /**
     * @param ProductStatus $status
     */
    public function setStatusAttribute(ProductStatus $status)
    {
        $this->attributes['status'] = $status->getValue();        
    }
    
}
```

##### Adding Fields

The most common thing is to add new fields to entities.

How to do that? Add a migration that adds the fields to the underlying db table and you're done. Say we're adding the `is_active` field:

```php
    Schema::table('products', function (Blueprint $table) {
        $table->boolean('is_active')->default(true);
    });
```

If the migration has run, you can access the new field with `$product->is_active`. Nothing to see here.

##### Adding A DateTime Field

Let's say you want to add the `last_purchased_at` field that holds a datetime.

```php
    Schema::table('products', function (Blueprint $table) {
        $table->dateTime('last_purchased_at')->nullable();
    });
```

It's starting. After the migration if you access this field via `$product->last_purchased_at` you'll get a string, not a Carbon (DateTime) object. Bummer.

For that to work, you'd need to add the field to the model's `dates` array:

```php
protected $dates = ['created_at', 'updated_at', 'last_purchased_at'];
```
So you need to extend the model. True, it's not an absolute must, you can get away with the string value.

##### Overriding Accessors & Mutators

If you want to extend the `ProductStatus` type with new statuses, then you need to override the accessor/mutator for accepting the extended variant.

You can still get away with that. No type hinting, just strings and go.

##### Attribute Casting

[Attribute casting](https://laravel.com/docs/5.4/eloquent-mutators#attribute-casting) is another nice feature of Eloquent. If you want your `is_active` field to be represented as boolean, you need to extend the `Product` model and set:

```php
    protected $casts = [
        'is_active' => 'boolean',
    ];
```

Can a developer live without it? Yes, but yet another feature less.

##### Adding Scopes

If you want to add your own [scopes](https://laravel.com/docs/5.4/eloquent#query-scopes) (either local or global) to your model then you've found another reason why you need to override the base model class.

##### Relationships

Maybe you can live without scopes, attribute casting and mutators, but I doubt you'd give up model [relationships](https://laravel.com/docs/5.4/eloquent-relationships).

In our reading, this is the **achilles heel** of the whole story.

Illustration:

**The Module Layer**:

`Product.php`:
```php

namespace Vendor\ProductModule\Models\Entities;

class Product extends Model
{
    
}
```

`Order.php`:
```php

namespace Vendor\OrderModule\Models\Entities;

use Vendor\ProductModule\Models\Entities\Product;

class OrderItem extends Model
{
    public function product()
    {
        $this->hasOne(Product::class);
    }
}
```

**The Application Layer**:

`Product.php`:
```php

namespace App;

use Vendor\ProductModule\Models\Entities\Product as BaseProduct;

class Product extends BaseProduct
{
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'last_purchased_at'];
}
```

What will you get if you access `$orderItem->product` ?

`Vendor\ProductModule\Models\Entities\Product` and not `App\Product`.

Since you only have control above the application layer (unless you're ok with modifying the vendor's class directly which is usually crap) you're stuck.

If it's done even in the lowest layers, Concord's **model**&**useModel** methods let you override the Model classes. See how.

### The Solution

1. Make an interface for your entities in the model layer.
2. Your base model must implement that interface.
3. Set the model class in relationship definitions via `concord()->model(EntityInterface::class)` using the interface.
4. Define the basic interface/entity binding in module provider's register method with `$this->app->concord->useModel(EntityInterface::class, Entity::class);`.
5. In upper layers override the model class with `$this->app->concord->useModel(EntityInterface::class, ExtendedEntity::class);`.
6. Always type hint the entity with it's interface (binding is also registered with the container).

#### Solution With Code Examples

1) **Make an interface** for your entities in the model layer.

`Vendor\Module\Contracts\Product.php`:

```php
namespace Vendor\Module\Contracts;

interface Product {}
```

2) Your base model must **implement that interface**.

`Vendor\Module\Models\Entities\Product.php`:

```php
namespace Vendor\Module\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Vendor\Module\Contracts\Product as ProductInterface;

class Product extends Model implements ProductInterface
{
    
}
```

3) Set the model class in definitions of a **relationship with Concord's `model()` method and the interface**.

`Vendor\Module\Models\Entities\OrderItem.php`:
```php
namespace Vendor\Module\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Vendor\Module\Contracts\Product;

class OrderItem extends Model
{
    public function product()
    {
        return $this->hasOne(concord()->model(Product::class), 'product_id', 'id');        
    }
}
```

4) **Define the basic interface/entity binding** in module provider's register method.

`Vendor\Module\Providers\ModuleServiceProvider.php`:
```php
namespace Vendor\Module\Providers;

use Konekt\Concord\AbstractModuleServiceProvider;
use Vendor\Module\Contracts\Product as ProductInterface;
use Vendor\Module\Models\Entities\Product;

class ModuleServiceProvider extends AbstractModuleServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->concord->useModel(ProductInterface::class, Product::class);
    }
}
```

5) In upper layers (application, box) **override the model** class with Concord's `useModel()` method.

`App\Providers\AppServiceProvider.php`:
```php
namespace App\Providers;

use App\Product;
use Illuminate\Support\ServiceProvider;
use Vendor\Module\Contracts\Product as ProductInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->concord->useModel(ProductInterface::class, Product::class);
    }
}
```

6) Always **type hint the entity with it's interface** (binding is also registered with the container)

```php
namespace App\Http\Controllers;

use Vendor\Module\Contracts\Product;

class ExampleController extends Controller
{
    public function edit(Product $product)
    {
        dd($product); // <- it will be App\Product if overwritten, the default otherwise        
    }
}
```

#### Next: [Repositories &raquo;](repositories.md)