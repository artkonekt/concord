# Request Types

Concord encourages the use of Laravel's
[Form Request validation](https://laravel.com/docs/8.x/validation#form-request-validation).

As they closely relate to models, and are very often a subject to customization,
their use with Concord is very similar to [models](models.md) and
[enums](enums.md).

## Registering Form Request Types

Request types provided by modules need to be registered with Concord. This will
help applications to easily customize them.

1. **Make an interface** for your requests in the `Contracts/Requests` folder
2. **Define the request** class, that must implement that interface.
3. **Register the requests** in the module's service provider by listing the model classes in the `$requests` property:
    ```php
        protected $models = [
            Product::class,
            Attribute::class
        ];
    ```
4. Always **type hint requests with their interface** (binding is also registered
   with the container).
5. To customize the request in your app **override the request class** with
   Concord's `registerRequest()` method eg.
   `$this->app->concord->registerRequest(UpdateProductContract::class,
   App\Http\Requests\UpdateProduct::class);`.


**Example:**

*The Interface:*
```php
// Contracts/Requests/CreateCustomer.php
namespace Konekt\AppShell\Contracts\Requests;

interface CreateCustomer extends Konekt\Concord\Contracts\BaseRequest {}
```

> Concord provides the `Konekt\Concord\Contracts\BaseRequest` interface as a
> boilerplate that can be used by any request contract. Its absolutely optional,
> but is useful as it complies with the Laravel `FormRequest` requirements.

*The Request Type:*
```php
// Http/Requests/CreateCustomer.php
namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\CreateCustomer as CreateCustomerContract;

class CreateCustomer extends FormRequest implements CreateCustomerContract
{
    public function rules()
    {
        return [
            'type'         => ['required', Rule::in(['individual', 'organization'])],
            'firstname'    => 'required_if:type,individual',
            'lastname'     => 'required_if:type,individual',
            'company_name' => 'required_if:type,organization',
        ];
    }
    
    public function authorize()
    {
        return true;
    }
}
```

*Register With The Module:*
```php
// Providers/ModuleServiceProvider.php

namespace Konekt\AppShell\Providers;

use Konekt\AppShell\Http\Requests\CreateCustomer;
use Konekt\AppShell\Http\Requests\UpdateCustomer;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $requests = [
        CreateCustomer::class,
        UpdateCustomer::class
    ];
}
```

*Using In Controller Action:*
```php
// Http/Controllers/CustomerController.php

namespace Konekt\AppShell\Http\Controllers;

use Konekt\AppShell\Contracts\Requests\CreateCustomer;
use Konekt\Customer\Contracts\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerType;
use Konekt\Customer\Models\CustomerTypeProxy;

class CustomerController extends Illuminate\Routing\Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function store(CreateCustomer $request)
    {
        try {
            CustomerProxy::create($request->all());
            flash()->success(__('Customer has been created'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
            return redirect()->back()->withInput();
        }
        
        return redirect(route('appshell.customer.index'));
    }
}
```

## Customizing Requests

Applications very often define their own validation logic compared to what
modules define out of the box. This can be achieved by modifying a request type
that was registered within a module.

*The steps are:*

1. Override the Request class,
2. Register it with Concord.

**Example:**

*Customized Request Class:*
```php
// The original enum class in an underlying module:
namespace App\Http\Requests;

class CreateCustomer extends \Konekt\AppShell\Http\Requests\CreateCustomer
{
    // Define the customized rules
    public function rules()
    {
        $rules = parent::rules();
        
        unset($rules['type']);
        $rules['tax_id'] = 'required';
        
        return $rules;
    }
}
```

*Register with concord:*
```php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->concord->registerRequest(
            \Konekt\AppShell\Contracts\Requests\CreateCustomer::class,
            \App\Http\Requests\CreateCustomer::class
        );
    }
}
```

**Next**: [Notifications &raquo;](notifications.md)
