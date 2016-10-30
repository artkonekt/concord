<?php
/**
 * Contains the ConcordServiceProvider.php class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */


namespace Konekt\Concord;

use Illuminate\Support\ServiceProvider;
use Konekt\Concord\Console\Commands\ListCommand;
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
        $this->app->singleton('concord', function ($app) {
            return new Concord($app);
        });

        $this->app->singleton('concord.helper', function ($app) {
            return new HelperFactory($app->config->get('concord.helpers'), $app);
        });

        $this->registerListCommand();
    }


    /**
     * Post-registration booting
     *
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views
        $modules = config("concord.modules");
        $modules = $modules ?: [];

        foreach ($modules as $module) {
            $this->app['concord']->registerModule($module);
        }

        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('concord.php')
        ], 'config');

    }
    /**
     * Returns the provided services
     *
     * @return array
     */
    public function provides()
    {
        return [
            'concord',
            'concord.helper'
        ];
    }

    /**
     * Register the concord:list command.
     */
    protected function registerListCommand()
    {
        $this->app->singleton('command.concord.list', function ($app) {
            return new ListCommand($app['concord']);
        });

        $this->commands('command.concord.list');
    }


}