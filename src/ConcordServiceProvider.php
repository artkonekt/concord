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
use Konekt\Concord\Console\Commands\ModelsCommand;
use Konekt\Concord\Console\Commands\ModulesCommand;
use Konekt\Concord\Console\Commands\MakeModuleCommand;
use Konekt\Concord\Contracts\Concord as ConcordContract;
use Konekt\Concord\Helper\HelperFactory;


class ConcordServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
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

        $this->app->singleton('concord.helper', function ($app) {
            return new HelperFactory($app->config->get('concord.helpers'), $app);
        });

        $this->registerCommands();

        $modules = config("concord.modules") ?: [];

        foreach ($modules as $module) {
            $concordInstance->registerModule($module);
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
                MakeModuleCommand::class
            ]);
        }

    }


}