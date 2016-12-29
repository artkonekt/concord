<?php
/**
 * Contains the Module Loader class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */


namespace Konekt\Concord\Module;


use Illuminate\Contracts\Foundation\Application;
use Konekt\Concord\Contracts\ModuleInterface;


class Loader
{
    /** @var Application  */
    protected $app;

    /**
     * Loader constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Loads a module based on its class name
     *
     * @param string $moduleClass The full classname of the Module's ModuleServiceProvider class
     *
     * @return ModuleInterface
     */
    public function loadModule($moduleClass)
    {
        /** @var ModuleInterface $module */
        $module = $this->app->register($moduleClass);

        return $module;
    }

}