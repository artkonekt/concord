# Entities (Eloquent Models)

Entities are the *nouns* in your system (like product, order, customer, subscription, etc).

Concord *(being a disciplined Laravel citizen)* uses Eloquent models for that. Yes, Active Record with all its curses and goodies.

## Preface

As Concord has been created for flexible, modular, "pluginizable" architecture, **it's inevitable to have additional complexity** compared to standalone Laravel applications.

One of the essential goals of Concord is to support creating **reusable code** for Laravel applications. As an example you can create yourself or use a 3rd party [module](modules.md) for managing products. You pull that module in your application with composer and consider that module as **immutable** (indifferent whether it's your own creation or third party). Immutable but your application may want to **extend** it.

> Did you notice that this is a real life use case of [SOLID's *open-close* principle](https://en.wikipedia.org/wiki/Open/closed_principle)?

The **product module** is a *lower* layer and your **application** is an *upper* layer. This document discusses both perspectives:

- How to author reusable modules (ie coding the lower layer);
- How to extend modules in your application.

Obviously a module is only immutable from the application's perspective. As a module author you definitely want to evolve your module.

Therefore another essential feature you want is to **be able to update the underlying modules in your application** without breaking your code. (Two words: [Semantic Versioning](http://semver.org/))

From the Entities perspective our goal is to outsource basic functionality in modules, ie having basic versions of our *nouns* ready to be customized by the application. For this goal we need a well defined path for extending/overriding Eloquent model classes defined in *lower layers* (module).

## Overriding Entites (Models)

[For tl;dr click here](#concords-solution)

### The Problem

In our interpretation, good platforms:

- provide the essential functionality out of the box, and
- make it easy to customize their basic behavior.

As an example there is the `Product` model. It's defined in a *lower* layer, in the product **module**. *Upper* layers, like the final **application** will want to alter/extend it so that it doesn't break the basic functionality of the module.

Possible modifications can be:

- Adding fields,
- Removing fields,
- Altering fields (via accessors and mutators),
- Adding scopes,
- Adding relationships.

Most of these can be done by adding migrations and extending the original Model class using simple OOP inheritance. The essence of the problem is **how will your lower level modules know that the system is using an extended class** for that entity?

The most trivial scenario of this kind appears when you define an [Eloquent relationship](https://laravel.com/docs/5.4/eloquent-relationships). Say you have `ModuleProduct` and `AppProduct` (which extends ModuleProduct). You also have a `FavoriteItem` class defined outside your application which has a relationship to the product.

**Traditional approach**:

```php
namespace Vendor\FavouriteModule;

use Illuminate\Database\Eloquent\Model;
use Vendor\ProductModule\Product as ModuleProduct;

class FavouriteItem extends Model
{
    public function product()
    {
        // Related class `ModuleProduct` gets carved in stone
        return $this->hasOne(ModuleProduct::class);        
    }
} 
```
The product relationship will always return `ModuleProduct` instead of `AppProduct` because it knows nothing about the fact you've extended it in your application.

Theoretically it's possible to also extend the `FavouriteItem` class and update the `product` relationship, but then you'd need to check every reference to products and do the same, which is utterly stupid.

**Concord's (late binding) approach**:

```php
namespace Vendor\FavouriteModule;

use Illuminate\Database\Eloquent\Model;
use Vendor\ProductModule\Contracts\Product; // Note: this is an interface

class FavouriteItem extends Model
{
    public function product()
    {
        // Related class gets resolved later
        return $this->hasOne(concord()->model(Product::class));        
    }
} 
```

This way we need to have an interface `Product` and we can freely bind a concrete class to it using Concord's `useModel()` method. First `ModelProduct` class gets assigned within the module (consider it as a default). If the application wants to extend that class, it invokes `useModel()` again, and that's all.

The `useModel()` method also silently [binds the interface to the implementation with Laravel's service container](https://laravel.com/docs/5.4/container#binding-interfaces-to-implementations) so you can simply type hint the interface at any point where [automatic injection](https://laravel.com/docs/5.4/container#automatic-injection) happens.

```php
use Vendor\ProductModule\Contracts\Product; // Note that it's the Interface

class ProductController extends Controller
{
    public function show(Product $product)
    {
        dd($product); // <- this will be AppProduct
    }
}
```

## Detailed Example

You'll be guided through an example, that demonstrates the possible modifications of an entity across layers.

Say whe have a **product** module, that contains the `Product` class (an eloquent model) which has the following attributes (fields):

- id
- sku
- title
- status (draft, active, retired)
- price
- description

With Eloquent, you can get fields like `$product->sku`, `$product->title`, etc.

#### Adding Fields

The most common thing is to add new fields to entities.

How to do that? Add a migration that adds the fields to the underlying db table and you're done. Say we're adding the `is_active` field:

```php
    Schema::table('products', function (Blueprint $table) {
        $table->boolean('is_active')->default(true);
    });
```

If the migration has run, you can access the new field with `$product->is_active`. Nothing special so far.

#### Adding A DateTime Field

Let's say you want to add the `last_purchased_at` field that holds a datetime. Add this migration:

```php
    Schema::table('products', function (Blueprint $table) {
        $table->dateTime('last_purchased_at')->nullable();
    });
```

After the migration if you access this field via `$product->last_purchased_at` you'll get a string, not a Carbon (DateTime) object. Bummer.

For that to work, you need to add the field to the model's `dates` array:

```php
protected $dates = ['created_at', 'updated_at', 'last_purchased_at'];
```
So you need to extend the model class. Keep reading to see how.

#### Overriding Accessors & Mutators

Imagine you have this [accessor/mutator](https://laravel.com/docs/5.4/eloquent-mutators) pair in your model:

```php
class SomeModel extends Model
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

If you want to extend the base `ProductStatus` type with new statuses, then you need to extend that status class and override the accessor/mutator of the Entity for accepting the extended variant.

#### Attribute Casting

[Attribute casting](https://laravel.com/docs/5.4/eloquent-mutators#attribute-casting) is another nice feature of Eloquent. If you want your `is_active` field to be represented as boolean, you need to extend the `Product` model and set:

```php
    protected $casts = [
        'is_active' => 'boolean',
    ];
```

#### Adding Scopes

If you want to add your own [scopes](https://laravel.com/docs/5.4/eloquent#query-scopes) (either local or global) to your model then you've found another reason why you need to override the base model class.

#### Relationships

Maybe you can live without scopes, attribute casting and mutators, but I doubt you'd give up model [relationships](https://laravel.com/docs/5.4/eloquent-relationships).

In our reading, this is the **achilles heel** of the whole story. Read below to see how it can be achieved.

### Concord's Solution

1. **Make an interface** for your entities in the *module layer*.
2. Your **base model** must implement that interface.
3. **Define the default** interface/entity binding in the module provider's register method with `$this->app->concord->useModel(EntityInterface::class, DefaultEntity::class);`.
4. Set the related model class in **relationship definitions** with `concord()->model(EntityInterface::class)` using the interface.
5. In upper layers (application) **override the model class** with `$this->app->concord->useModel(EntityInterface::class, ExtendedEntity::class);`.
6. Always **type hint entities with their interface** (binding is also registered with the container).
7. **Don't create entity objects with `new`**`Entity()`, let Laravel make it from the interface.

#### Solution With Code Examples

##### 1) *Make an interface* for your entities in the model layer.

`Vendor\ProductModule\Contracts\Product.php`:

```php
namespace Vendor\ProductModule\Contracts;

interface Product {}
```

##### 2) Your base model must *implement that interface*.

`Vendor\ProductModule\Models\Entities\Product.php`:

```php
namespace Vendor\ProductModule\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Vendor\ProductModule\Contracts\Product as ProductContract;

class Product extends Model implements ProductContract
{
    
}
```

##### 3) *Define the basic interface/entity binding* in module provider's register method.

`Vendor\ProductModule\Providers\ModuleServiceProvider.php`:
```php
namespace Vendor\Module\Providers;

use Konekt\Concord\AbstractModuleServiceProvider;
use Vendor\ProductModule\Contracts\Product as ProductContract;
use Vendor\ProductModule\Models\Entities\Product;

class ModuleServiceProvider extends AbstractModuleServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->concord->useModel(ProductContract::class, Product::class);
    }
}
```

##### 4) Set the model class in definitions of a *relationship with Concord's `model()` method and the interface*.

`Vendor\OrderModule\Models\Entities\OrderItem.php`:
```php
namespace Vendor\OrderModule\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Vendor\ProductModule\Contracts\Product;

class OrderItem extends Model
{
    public function product()
    {
        return $this->hasOne(concord()->model(Product::class), 'product_id', 'id');        
    }
}
```

##### 5) In upper layers (application, box) *override the model* class with Concord's `useModel()` method.

`App\Providers\AppServiceProvider.php`:
```php
namespace App\Providers;

use App\Product;
use Illuminate\Support\ServiceProvider;
use Vendor\ProductModule\Contracts\Product as ProductContract;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->concord->useModel(ProductContract::class, Product::class);
    }
}
```

##### 6) Always *type hint the entity with it's interface* ([binding](https://laravel.com/docs/5.4/container#binding-interfaces-to-implementations) is also registered with the container)

```php
namespace App\Http\Controllers;

use Vendor\ProductModule\Contracts\Product;

class ExampleController extends Controller
{
    public function edit(Product $product)
    {
        dd($product); // <- it will be App\Product if overwritten, the default otherwise        
    }
}
```

##### 7) *Don't create entity objects with* `new Entity()`, let Laravel make it from the interface.

Since entities are moving parts, it's generally unwanted to create entity (model) classes with the **`new`** keyword, let the Laravel container to make that class for you based on the interface.

*Controller Actions*:

```php
use Vendor\ProductModule\Contracts\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        get_class($product); // <- this will be the proper type
    }
}
```

*Explicit Creation*:

```php
use Vendor\ProductModule\Contracts\Product;

class SomeFactory
{
    public function createEmptyProduct()
    {
        return app()->make(Product::class);        
    }
}
```

#### Naming And Aliasing Conventions

Following the Laravel coding style, we don't give interfaces an `Interface` suffix, so we'll have 3 different things with the name `Product` in the example above:

- the interface,
- the default class and
- the extended class.

According to Laravel's conventions, this is the recommended solution for resolving namespace/name conflicts:

| Location                 | FQCN                            | Alias As           |
|--------------------------|-----------------------------------------|--------------------|
| Default Product *(module)*  | `Vendor\Module\Models\Contracts\Product` | **ProductContract** |
| ServiceProvider *(module, app)* | `Vendor\Module\Models\Contracts\Product` | **ProductContract** |
| ServiceProvider *(module,app)* | `Vendor\Module\Models\Entities\Product`  | *as is*            |
| Extended Product *(app)* | `Vendor\Module\Models\Contracts\Product` | **ProductContract** |
| Extended Product *(app)* | `Vendor\Module\Models\Entities\Product`  | **BaseProduct**     |



#### Next: [Repositories &raquo;](repositories.md)