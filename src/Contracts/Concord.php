<?php
/**
 * Contains the Concord interface.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-10-30
 */

namespace Konekt\Concord\Contracts;

use Illuminate\Support\Collection;

interface Concord
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
     * @param string $name
     * @param string $class
     */
    public function registerHelper($name, $class);

    /**
     * Utility method for registering aliases/facades to Laravel's service container
     *
     * @param string    $alias      The short name of the facade (eg. `Foo`)
     * @param string    $concrete   The concrete implementation's class (eg. `Vendor\Chewbakka\Foo`)
     */
    public function registerAlias($alias, $concrete);

    /**
     * Returns the collection of available modules
     *
     * @param bool $includeImplicits
     *
     * @return Collection
     */
    public function getModules($includeImplicits = false): Collection;

    /**
     * Register/overwrite a model for a specific abstract/interface
     *
     * @param string $abstract
     * @param string $concrete
     * @param bool   $registerRouteModel    Whether or not to register with Route::model()
     *
     * @return void
     */
    public function registerModel(string $abstract, string $concrete, $registerRouteModel = true);

    /**
     * Return the Model class for a specific abstract class
     *
     * @param string    $abstract
     *
     * @return string
     */
    public function model(string $abstract);

    /**
     * Returns a module by its id
     *
     * @param string    $id
     *
     * @return Module|null
     */
    public function module(string $id);

    /**
     * Returns all model bindings
     *
     * @return Collection
     */
    public function getModelBindings(): Collection;

    /**
     * Register/overwrite an enum for a specific abstract/interface
     *
     * @param string    $abstract
     * @param string    $concrete
     *
     * @return void
     */
    public function registerEnum(string $abstract, string $concrete);

    /**
     * Register/overwrite a request for a specific abstract/interface
     *
     * @param string    $abstract
     * @param string    $concrete
     *
     * @return void
     */
    public function registerRequest(string $abstract, string $concrete);

    /**
     * Return the Enum class for a specific abstract class
     *
     * @param string    $abstract
     *
     * @return string
     */
    public function enum(string $abstract);

    /**
     * Returns all enum bindings
     *
     * @return Collection
     */
    public function getEnumBindings(): Collection;

    /**
     * Returns all request bindings
     *
     * @return Collection
     */
    public function getRequestBindings(): Collection;

    /**
     * Returns the the current convention
     *
     * @return Convention
     */
    public function getConvention(): Convention;

    /**
     * Returns a helper instance for the specified helper name
     *
     * @param string    $name       The name of the helper
     * @param array     $arguments  Optional arguments to pass to the helper class
     *
     * @return object|null
     */
    public function helper($name, $arguments = []);

    /**
     * Returns the Concord version (the library itself)
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Returns the complete abstract class/interface name for a short name
     *
     * @param string    $name   The short name
     *
     * @return string|null
     */
    public function short($name);
}
