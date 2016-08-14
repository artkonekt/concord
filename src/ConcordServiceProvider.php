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

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Konekt\Concord\Console\Commands\ListCommand;


class ConcordServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
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

        while (list(, $module) = each($modules)) {
            App::register($module);
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
            'concord'
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