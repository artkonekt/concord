<?php
/**
 * Contains the ConcordServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */

namespace Konekt\Concord;

use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Konekt\Concord\Console\Commands\EnumsCommand;
use Konekt\Concord\Console\Commands\ModelsCommand;
use Konekt\Concord\Console\Commands\ModulesCommand;
use Konekt\Concord\Console\Commands\MakeModuleCommand;
use Konekt\Concord\Console\Commands\RequestsCommand;
use Konekt\Concord\Console\Commands\VersionCommand;
use Konekt\Concord\Contracts\Concord as ConcordContract;
use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Conventions\ConcordDefault;

class ConcordServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Set convention to use
        $this->app->bind(
            Convention::class,
            $this->resolveConventionClass(
                $this->app->config->get('concord.convention', 'default')
            )
        );

        // Register interface -> actual class binding as singleton
        // For the sake of flexibility it's possible to replace
        // the actual class by setting `class` in the config
        $this->app->singleton(
            ConcordContract::class,
            $this->app->config->get('concord.class', Concord::class)
        );

        // Make an instance
        $concordInstance = $this->app->make(ConcordContract::class);
        // And make it available as the 'concord' service
        $this->app->instance('concord', $concordInstance);

        $this->registerCommands();

        $modules = config("concord.modules") ?: [];

        foreach ($modules as $key => $value) {
            $module = is_string($key) ? $key : $value;
            $config = is_array($value) ? $value : [];
            $concordInstance->registerModule($module, $config);
        }
    }

    /**
     * Post-registration booting
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('concord.php')
        ], 'config');
    }

    /**
     * Register the console commands of this package
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModulesCommand::class,
                ModelsCommand::class,
                EnumsCommand::class,
                RequestsCommand::class,
                MakeModuleCommand::class,
                VersionCommand::class
            ]);
        }
    }

    /**
     * Resolve the convention class
     *
     * @param string $name Either a short name like 'default' or an FQCN
     *
     * @return string
     */
    private function resolveConventionClass(string $name)
    {
        if ('default' == $name) {
            return ConcordDefault::class;
        } elseif (class_exists($name)) {
            return $name;
        }

        throw new InvalidArgumentException(
            sprintf('%s is not a valid convention class', $name)
        );
    }
}
