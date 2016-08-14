<?php
/**
 * Contains the Concord.php class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */


namespace Konekt\Concord;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Konekt\Concord\Module\Loader;

class Concord
{
    /** @var Collection  */
    protected $modules;

    /** @var  Loader */
    protected $loader;

    /** @var  Application */
    protected $app;

    /**
     * Concord class constructor
     */
    public function __construct(Application $app)
    {
        $this->modules = Collection::make([]);
        $this->app     = $app;
    }


    /**
     * Registers a new module based on its class name
     *
     * @param string    $moduleClass
     */
    public function registerModule($moduleClass)
    {
        $module = $this->getLoader()->loadModule($moduleClass);

        $this->modules->push($module);
    }

    /**
     * Returns the collection of available modules
     *
     * @return Collection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Returns the Module Loader instance (lazy load)
     *
     * @return Loader
     */
    protected function getLoader()
    {
        if (!$this->loader) {
            $this->loader = new Loader($this->app);
        }

        return $this->loader;
    }

}