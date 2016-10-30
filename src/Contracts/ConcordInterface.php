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
     * @param string    $moduleClass
     */
    public function registerModule($moduleClass);

    /**
     * Registers a helper
     *
     * @param string    $name
     * @param string    $moduleClass
     */
    public function registerHelper($name, $moduleClass);

    /**
     * Returns the collection of available modules
     *
     * @return Collection
     */
    public function getModules();

}