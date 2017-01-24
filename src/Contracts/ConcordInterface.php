<?php
/**
 * Contains the ConcordInterface class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-10-30
 *
 */


namespace Konekt\Concord\Contracts;


interface ConcordInterface
{

    /**
     * Registers a new module based on its class name
     *
     * @param string $moduleClass
     * @param array  $config
     *
     * @return
     */
    public function registerModule($moduleClass, $config = []);

    /**
     * Registers a helper
     *
     * @param string    $name
     * @param string    $moduleClass
     */
    public function registerHelper($name, $moduleClass);

    /**
     * Utility method for registering facades to Laravel's service container
     *
     * @param $alias
     * @param $concrete
     */
    public function registerFacade($alias, $concrete);

    /**
     * Returns the collection of available modules
     *
     * @param bool $includeImplicits
     *
     * @return Collection
     */
    public function getModules($includeImplicits = false);

}