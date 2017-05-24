<?php
/**
 * Contains the Concord class.
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
use Konekt\Concord\Contracts\Concord as ConcordContract;
use Konekt\Concord\Contracts\Convention;

class Concord implements ConcordContract
{
    /** @var Collection  */
    protected $modules;

    /** @var array */
    protected $models = [];

    /** @var array */
    protected $enums = [];

    /** @var  array */
    protected $implicitModules = [];

    /** @var  Loader */
    protected $loader;

    /** @var  Application */
    protected $app;

    /** @var Convention */
    private $convention;

    /**
     * Concord class constructor
     *
     * @param Application $app
     * @param Convention  $convention
     */
    public function __construct(Application $app, Convention $convention)
    {
        $this->modules    = Collection::make();
        $this->app        = $app;
        $this->convention = $convention;
    }


    /**
     * @inheritdoc
     */
    public function registerModule($moduleClass, $config = [])
    {
        $this->app['config']->set(concord_module_id($moduleClass), $config);
        $module = $this->app->register($moduleClass);

        $this->modules->push($module);
        $implicit = isset($config['implicit']) ? $config['implicit'] : false;

        if ($implicit) {
            $this->implicitModules[get_class($module)] = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function registerHelper($name, $class)
    {
        config([
            sprintf('concord.helpers.%s', $name) => $class
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
    public function registerAlias($alias, $concrete)
    {
        AliasLoader::getInstance()->alias($alias, $concrete);
    }

    /**
     * @inheritDoc
     */
    public function registerModel(string $abstract, string $concrete)
    {
        if (!is_subclass_of($concrete, $abstract, true)) {
            throw new InvalidArgumentException("Class {$concrete} must extend or implement {$abstract}. ");
        }

        $this->models[$abstract] = $concrete;
        $this->app->alias($concrete, $abstract);
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
     * @inheritdoc
     */
    public function getConvention(): Convention
    {
        return $this->convention;
    }

    /**
     * @inheritDoc
     */
    public function registerEnum(string $abstract, string $concrete)
    {
        if (!is_subclass_of($concrete, $abstract, true)) {
            throw new InvalidArgumentException("Class {$concrete} must extend or implement {$abstract}. ");
        }

        $this->enums[$abstract] = $concrete;
        $this->app->alias($concrete, $abstract);
    }

    /**
     * @inheritDoc
     */
    public function enum(string $abstract)
    {
        return array_get($this->enums, $abstract);
    }

    /**
     * @inheritDoc
     */
    public function getEnumBindings(): Collection
    {
        return collect($this->enums);
    }
}