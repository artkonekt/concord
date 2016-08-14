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


use Illuminate\Support\Collection;

class Concord
{
    /** @var Collection  */
    protected $modules;

    /**
     * Concord class constructor
     */
    public function __construct()
    {
        $this->modules = Collection::make([]);
    }


    /**
     * Registers a new module based on its class name
     *
     * @param string    $moduleClass
     */
    public function registerModule($moduleClass)
    {
        $module = new Module();
        $module->name = $moduleClass;

        App::register($moduleClass);

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

}