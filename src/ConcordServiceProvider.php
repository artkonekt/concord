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

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Konekt\Concord\Console\Commands\ListCommand;
use Konekt\Concord\Console\Commands\MakeModuleCommand;
use Konekt\Concord\Contracts\ConcordInterface;
use Konekt\Concord\Helper\HelperFactory;


class ConcordServiceProvider extends ServiceProvider
{
    /** @var  ConcordInterface */
    protected $concordInstance;

    /**
     * ModuleServiceProvider class constructor
     *
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $app->bind(
            ConcordInterface::class,
            $app->config->get('concord.class', Concord::class)
        );

        $this->concordInstance = $app->make(ConcordInterface::class);
    }


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('concord', $this->concordInstance);

        $this->app->singleton('concord.helper', function ($app) {
            return new HelperFactory($app->config->get('concord.helpers'), $app);
        });

        $this->registerListCommand();
        $this->registerMakeModuleCommand();

        // For each of the registered modules, include their routes and Views
        $modules = config("concord.modules");
        $modules = $modules ?: [];

        foreach ($modules as $module) {
            $this->concordInstance->registerModule($module);
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