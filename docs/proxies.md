# Proxies

Concord's proxies concept is probably its most uncommon feature. The reason why
they came to life is described in depth at the [models](models.md)
section.

> **Proxies have to be used rather by module authors, and shouldn't be used in applications.**

Concord as of v1.0 supports two kinds of proxies:

- Model proxies,
- Enum proxies.

## Why Proxies?

To sum it up, proxies help writing modules which contain eloquent models that
can be easily customized by the consuming application.

A Concord proxy class redirects to the concrete implementation of a model (or
enum). This might sound fuzzy, so here's an example:

**Example:**

Imagine you create a very-very minimal **shop module**, that is on github and
can be used by any laravel application.

- The module defines a `Product` and an `Order` model.
- An order contains one product (via an [eloquent relationship](https://laravel.com/docs/8.x/eloquent-relationships#one-to-one)).
- The product model has a name, sku and price fields.

Let's say you (or someone else) uses this module in an application but wants to
add a description field to the product model.

How will the `Order` model know to use the extended product model?

Here's where the model proxy comes in, the minimal shop module has to use the proxy
class for defining the relationship:

```php
namespace Minimal\ShopModule\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function product()
    {
        // use the proxy to resolve the class
        return $this->belongsTo(ProductProxy::modelClass());
        
        // instead of the traditional Laravel approach:
        // return $this->belongsTo(Product::class);
    }
}
```

The application can register the updated product class (eg. `App\Product`) with
Concord:

```php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

class AppServiceProvider extends Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->app->concord->registerModel(
            \Minimal\ShopModule\Contracts\Product::class,
            \App\Product::class
        );
    }
}
```

This way the ProductProxy will resolve to the `App\Product` class.

## Proxying Methods

Other than resolving the actual class, the proxy actually proxies method calls
to the resolved class. So that you can use it as if it was a real model:

```php

ProductProxy::find(1);
// returns the registered model with id 1
ProductProxy::where('active', 1)->get();
// Returns the queried objects

ProductProxy::create(['name' => 'Lenovo l470 Notebook']);
// Creates an entry of the registered model class
```

## Interface, Model, Proxy Trinity

In order to have this kind of behavior, you need to define 3 things in the
modules:

1. **An interface** (contract) (identifies "the thing" (model/enum)) (eg. `Contracts\Product`)
2. **A model/enum implementation** (this is the moving part, can be replaced) (eg. `Models\Product`)
3. **A proxy** (eg. `Models\ProductProxy`)

The interface and the proxy are immutable, and shouldn't be extended.
The implementation is replaceable, using `concord()->registerModel()` and
`concord()->registerEnum()` methods.


**Next**: [Concord Events &raquo;](concord-events.md)
