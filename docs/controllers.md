# Controllers

A box can ship with predefined controllers, and they can be used directly or via routes.

## Using Custom Action

> **NOTE:** This is nothing Concord specific, Laravel provides these
> possibilities out of the box.

In case an app wants to extend a boxes controller AND wants to use the boxes built in routes, it should do the following thing:

1. Locate the route (preferably via it's name),
2. Set your own controller/action.

You can put this code either in your app's `RouteServiceProvider` or the
`AppServiceProvider` (or any service provider you prefer).

**Example:**
```php
//app/Providers/RouteServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    // [...]

    public function boot()
    {
        parent::boot();

        $route = Route::getRoutes()->getByName('vanilo.order.index');

        $routeAction = array_merge($route->getAction(), [
            'uses'       => '\App\Http\Controllers\Admin\OrderController@index',
            'controller' => '\App\Http\Controllers\Admin\OrderController@index',
        ]);

        $route->setAction($routeAction);
        $route->controller = false;
    }

    // [...]
}
```
*The Custom Controller:*
```php
//app/Http/Controllers/Admin/OrderController.php
namespace App\Http\Controllers\Admin;

class OrderController extends \Vanilo\Framework\Http\Controllers\OrderController
{
    public function index()
    {
        // Custom code
        flash('Cogito ergo sum.');

        // Invoke the original action - if you want
        return parent::index();
    }
}
```

**Next**: [Commands &raquo;](commands.md)
