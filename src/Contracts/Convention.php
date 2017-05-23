<?php
/**
 * Contains the Convention interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-14
 *
 */


namespace Konekt\Concord\Contracts;


/**
 * Convention is the layout of folders, files, namespaces used by Concord
 *
 * Paths are relative to the module root by default
 */
interface Convention
{
    /**
     * Returns the folder name for modules
     *
     * @return string
     */
    public function modulesFolder() : string;

    /**
     * Returns the folder name for Model classes
     *
     * @return string
     */
    public function modelsFolder() : string;

    /**
     * Returns the folder name for Contracts (interfaces)
     *
     * @return string
     */
    public function contractsFolder() : string;

    /**
     * Returns the folder name for Controllers
     *
     * @return string
     */
    public function controllersFolder() : string;

    /**
     * Returns the folder name for config files
     *
     * @return string
     */
    public function configFolder() : string;

    /**
     * Returns the folder name for migration files
     *
     * @return string
     */
    public function migrationsFolder() : string;

    /**
     * Returns the folder name for Provider classes
     *
     * @return string
     */
    public function providersFolder() : string;

    /**
     * Returns the base folder name for views
     *
     * @return string
     */
    public function viewsFolder() : string;

    /**
     * Returns the folder name for route files
     *
     * @return string
     */
    public function routesFolder() : string;

    /**
     * Returns the path + filename to the manifest file relative to the module
     *
     * @return string
     */
    public function manifestFile() : string;

    /**
     * Return the contract class (interface) for the given model class according to the convention
     *
     * @param string $modelClass
     *
     * @return string
     */
    public function contractForModel(string $modelClass) : string;

    /**
     * Return the model class for the given repository according to the convention
     *
     * @param string $repositoryClass
     *
     * @return string
     */
    public function modelForRepository(string $repositoryClass) : string;

    /**
     * Return the model class for the given proxy according to the convention
     *
     * @param string $proxyClass
     *
     * @return string
     */
    public function modelForProxy(string $proxyClass) : string;

    /**
     * Returns the repository class for a given model according to the convention
     *
     * @param string $modelClass
     *
     * @return mixed
     */
    public function repositoryForModel(string $modelClass) : string;

    /**
     * Returns the proxy class for a given model according to the convention
     *
     * @param string $modelClass
     *
     * @return mixed
     */
    public function proxyForModel(string $modelClass) : string;


}