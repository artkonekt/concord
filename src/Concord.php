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
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Konekt\Concord\Contracts\ConcordInterface;
use Konekt\Concord\Module\Loader;

class Concord implements ConcordInterface
{
    /** @var Collection  */
    protected $modules;

    /** @var array */
    protected $models = [];

    /** @var  array */
    protected $implicitModules = [];

    /** @var  Loader */
    protected $loader;

    /** @var  Application */
    protected $app;

    /**
     * Concord class constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->modules = Collection::make();
        $this->app     = $app;
    }


    /**
     * @inheritdoc
     */
    public function registerModule($moduleClass, $config = [])
    {
        $this->app['config']->set(concord_module_id($moduleClass), $config);
        $module = $this->getLoader()->loadModule($moduleClass);

        $this->modules->push($module);
        $implicit = isset($config['implicit']) ? $config['implicit'] : false;

        if ($implicit) {
            $this->implicitModules[get_class($module)] = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function registerHelper($name, $moduleClass)
    {
        config([
            sprintf('concord.helpers.%s', $name) => $moduleClass
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getModules($includeImplicits = false) : Collection
    {
        if ($includeImplicits) {
            return $this->modules;
        }

        $implicitModules = $this->implicitModules;

        return $this->modules->reject(function($module) use ($implicitModules) {
            return array_key_exists(get_class($module), $implicitModules);
        });
    }

    /**
     * @inheritdoc
     */
    public function registerFacade($alias, $concrete)
    {
        AliasLoader::getInstance()->alias($alias, $concrete);
    }

    /**
     * @inheritDoc
     */
    public function useModel(string $abstract, string $concrete)
    {
        if (!is_subclass_of($concrete, $abstract, true)) {
            throw new InvalidArgumentException("Class {$concrete} must extend or implement {$abstract}. ");
        }

        $this->models[$abstract] = $concrete;
        $this->app->bind($abstract, $concrete);
    }

    /**
     * @inheritDoc
     */
    public function model(string $abstract)
    {
        return array_get($this->models, $abstract);
    }

    /**
     * @inheritdoc
     */
    public function getModelBindings() : Collection
    {
        return collect($this->models);
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