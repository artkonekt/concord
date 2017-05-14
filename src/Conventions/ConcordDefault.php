<?php
/**
 * Contains the ConcordDefault convention class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-14
 *
 */


namespace Konekt\Concord\Conventions;


use Konekt\Concord\Contracts\Convention;

/**
 * Concord's default conventions
 */
class ConcordDefault extends BaseConvention implements Convention
{

    /**
     * @inheritdoc
     */
    public function modulesFolder() : string
    {
        return 'Modules';
    }

    /**
     * @inheritDoc
     */
    public function modelsFolder(): string
    {
        return 'Models';
    }

    /**
     * @inheritDoc
     */
    public function contractsFolder(): string
    {
        return 'Contracts';
    }

    /**
     * @inheritDoc
     */
    public function controllersFolder(): string
    {
        return 'Http/Controllers';
    }


    /**
     * @inheritDoc
     */
    public function contractForModel(string $modelClass) : string
    {
        return sprintf(
            '%s\\Contracts\\%s',
                $this->oneLevelUp($this->getNamespace($modelClass)),
                class_basename($modelClass)
        );
    }

    /**
     * @inheritDoc
     */
    public function modelForRepository(string $repositoryClass): string
    {
        return str_replace_last('Repository', '', $repositoryClass);
    }

    /**
     * @inheritDoc
     */
    public function modelForProxy(string $repositoryClass): string
    {
        return str_replace_last('Proxy', '', $repositoryClass);
    }

    /**
     * @inheritDoc
     */
    public function repositoryForModel(string $modelClass) : string
    {
        return $modelClass . 'Repository';
    }

    /**
     * @inheritDoc
     */
    public function proxyForModel(string $modelClass) : string
    {
        return $modelClass . 'Proxy';
    }

    /**
     * @inheritDoc
     */
    public function manifestFile() : string
    {
        return 'resources/manifest.php';
    }

    /**
     * @inheritDoc
     */
    public function configFolder(): string
    {
        return 'resources/config';
    }

    /**
     * @inheritDoc
     */
    public function migrationsFolder(): string
    {
        return 'resources/database/migrations';
    }

    /**
     * @inheritDoc
     */
    public function viewsFolder(): string
    {
        return 'resources/views';
    }

    /**
     * @inheritDoc
     */
    public function routesFolder(): string
    {
        return 'resources/routes';
    }
}