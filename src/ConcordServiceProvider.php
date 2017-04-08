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
use Konekt\Concord\Contracts\ConcordInterface;
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
        $this->app->singleton(
            ConcordInterface::class,
            $this->app->config->get('concord.class', Concord::class)
        );

        $concordInstance = $this->app->make(ConcordInterface::class);

        $this->app->instance('concord', $concordInstance);

        $this->app->singleton('concord.helper', function ($app) {
            return new HelperFactory($app->config->get('concord.helpers'), $app);
        });

        $this->registerModulesCommand();
        $this->registerModelsCommand();
        $this->registerMakeModuleCommand();

        $modules = config("concord.modules");
        $modules = $modules ?: [];

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
     * Register the concord:modules command.
     */
    protected function registerModulesCommand()
    {
        $this->app->singleton('command.concord.modules', function ($app) {
            return new ModulesCommand($app['concord']);
        });

        $this->commands('command.concord.modules');
    }

    /**
     * Register the concord:model command.
     */
    protected function registerModelsCommand()
    {
        $this->app->singleton('command.concord.models', function ($app) {
            return new ModelsCommand($app['concord']);
        });

        $this->commands('command.concord.models');
    }

    /**
     * Register the make:module command.
     */
    protected function registerMakeModuleCommand()
    {
        $this->app->singleton('command.concord.module.make', function ($app) {
            return new MakeModuleCommand($app['files']);
        });

        $this->commands('command.concord.module.make');
    }


}