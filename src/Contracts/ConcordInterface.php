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


use Illuminate\Support\Collection;

interface ConcordInterface
{

    /**
     * Registers a new module based on its class name
     *
     * @param string    $moduleClass
     * @param array     $config
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
     * @param string    $alias
     * @param string    $concrete
     */
    public function registerFacade($alias, $concrete);

    /**
     * Returns the collection of available modules
     *
     * @param bool $includeImplicits
     *
     * @return Collection
     */
    public function getModules($includeImplicits = false) : Collection;

    /**
     * Use/overwrite a model for a specific abstract/interface
     *
     * @param string    $abstract
     * @param string    $concrete
     *
     * @return void
     */
    public function useModel(string $abstract, string $concrete);

    /**
     * Return the Model class for a specific abstract class
     *
     * @param string    $abstract
     *
     * @return string
     */
    public function model(string $abstract);

    /**
     * Returns all model bindings
     *
     * @return Collection
     */
    public function getModelBindings() : Collection;
}