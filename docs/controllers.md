# Controllers

A module can ship with controllers which can be used directly or via predefined routes.

## Hooking Into Data Injection

> This feature is available since version 1.15

If you are developing a package you can allow the host application to modify the data injected into the views,
by making the controller hookable.

This can be very useful if the application has knowledge and access to data that the package is not aware of. 

To do this:

1. Add the `HasControllerHooks` trait to your controller;
2. Pass the view data through the `processViewData()` method.

```php
// Controller code in your package:
use \Konekt\Concord\Hooks\HasControllerHooks;

class ChannelController
{
    use HasControllerHooks;
    
    public function create()
    {
        return view('vanilo::channel.create', $this->processViewData(__METHOD__, [
            'countries' => Countries::pluck('name', 'id'),
            'currencies' => Currencies::choices(),
            'domains' => [],
        ]));
    }
    
    public function edit(Channel $channel)
    {
        return view('vanilo::channel.edit', $this->processViewData(__METHOD__, [
            'channel' => $channel,
            'countries' => Countries::pluck('name', 'id'),
            'currencies' => Currencies::choices(),
            'domains' => [],
        ]));
    }
}
```

Having the controller prepared this way, the application can modify the data passed to the view.

The example below will populate the `domains` variable that gets injected into the view with data:

```php
// Application code, most commonly the AppServiceProvider::boot() method:
ChannelController::hookInto('create', 'edit')
    ->viewDataInjection(function (array $viewData): array {
        $viewData['domains'] = tenant()->domains->pluck('domain', 'domain')->toArray();

        return $viewData;
    });
```

The hook will be called both in the create and the edit actions. 

## Using Custom Action

> **NOTE:** This solution is not Concord-specific, Laravel provides these possibilities out of the box.

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
