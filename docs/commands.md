# Commands

Boxes (or modules) can add their custom
[Artisan (CLI) commands](https://laravel.com/docs/8.x/artisan#writing-commands).

Their location should be the `Console/Commands` folder (following Laravel
defaults).

The commands need to be registered within the ModuleServiceProvider's register method:

**Example:**
```php
namespace Konekt\AppShell\Providers;

use Konekt\AppShell\Console\Commands\ScaffoldCommand;
use Konekt\AppShell\Console\Commands\SuperCommand;
use Konekt\Concord\BaseBoxServiceProvider;

class ModuleServiceProvider extends BaseBoxServiceProvider
{

    public function register()
    {
        parent::register();
        
        $this->registerCommands();
    }
    
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScaffoldCommand::class,
                SuperCommand::class
            ]);
        }
    }
}
```


**Next**: [Middleware &raquo;](middleware.md)
