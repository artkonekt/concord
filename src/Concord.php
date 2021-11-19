<?php

declare(strict_types=1);

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
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Konekt\Concord\Contracts\Concord as ConcordContract;
use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Events\EnumWasRegistered;
use Konekt\Concord\Events\HelperWasRegistered;
use Konekt\Concord\Events\ModelWasRegistered;
use Konekt\Concord\Events\RequestWasRegistered;
use Konekt\Concord\Hooks\HookEvent;
use Konekt\Concord\Hooks\Hooks;

final class Concord implements ConcordContract
{
    public const VERSION = '2.0-dev';

    /** @var Collection  */
    protected $modules;

    /** @var array */
    protected $models = [];

    /** @var array */
    protected $enums = [];

    /** @var array */
    protected $requests = [];

    /** @var  array */
    protected $implicitModules = [];

    /** @var  Application */
    protected $app;

    /** @var  array */
    protected $shorts = [];

    /** @var Convention */
    private $convention;

    private Hooks $hooks;

    /**
     * Concord class constructor
     *
     * @param Application $app
     * @param Convention  $convention
     */
    public function __construct(Application $app, Convention $convention)
    {
        $this->modules = Collection::make();
        $this->app = $app;
        $this->convention = $convention;
        $this->hooks = new Hooks();
    }

    /**
     * @inheritdoc
     */
    public function registerModule($moduleClass, $config = [])
    {
        if (is_not_a_concord_module_class($moduleClass)) {
            throw new InvalidArgumentException("$moduleClass is not a Concord Module class.");
        }
        $this->mergeModuleConfig($moduleClass::getId(), $config);

        $module = $this->app->register($moduleClass);

        $this->modules->put($module->getId(), $module);
        $implicit = $config['implicit'] ?? false;

        if ($implicit) {
            $this->implicitModules[get_class($module)] = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function registerHelper($name, $class)
    {
        $this->app->singleton('concord.helpers.' . $name, $class);

        event(new HelperWasRegistered($name, $class));
    }

    /**
     * @inheritdoc
     */
    public function getModules($includeImplicits = false): Collection
    {
        if ($includeImplicits) {
            return $this->modules;
        }

        $implicitModules = $this->implicitModules;

        return $this->modules->reject(function ($module) use ($implicitModules) {
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
    public function registerModel(string $abstract, string $concrete, $registerRouteModel = true)
    {
        if (!is_subclass_of($concrete, $abstract, true)) {
            throw new InvalidArgumentException("Class {$concrete} must extend or implement {$abstract}. ");
        }

        $this->models[$abstract] = $concrete;
        $this->app->alias($concrete, $abstract);
        $this->registerShort($abstract, 'model');

        // Route models can't resolve models by interface
        // so we're registering them explicitly
        if ($registerRouteModel) {
            $short = shorten($abstract);
            Route::model($short, $concrete);
            // Register both `payment_method` and `paymentMethod`:
            $camel = Str::camel(class_basename($abstract));
            if ($short !== $camel) {
                Route::model($camel, $concrete);
            }
        }

        $this->resetProxy($this->getConvention()->proxyForModelContract($abstract));
        event(new ModelWasRegistered($abstract, $concrete, $registerRouteModel));
    }

    /**
     * @inheritDoc
     */
    public function model(string $abstract)
    {
        return Arr::get($this->models, $abstract);
    }

    /**
     * @inheritDoc
     */
    public function module(string $id)
    {
        return $this->modules->get($id);
    }

    /**
     * @inheritdoc
     */
    public function getModelBindings(): Collection
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
        $this->registerShort($abstract, 'enum');

        $this->resetProxy($this->getConvention()->proxyForEnumContract($abstract));
        event(new EnumWasRegistered($abstract, $concrete));
    }

    /**
     * @inheritDoc
     */
    public function registerRequest(string $abstract, string $concrete)
    {
        if (!is_subclass_of($concrete, $abstract, true)) {
            throw new InvalidArgumentException("Class {$concrete} must extend or implement {$abstract}. ");
        }

        $this->requests[$abstract] = $concrete;
        $this->app->alias($concrete, $abstract);
        $this->registerShort($abstract, 'request');

        event(new RequestWasRegistered($abstract, $concrete));
    }

    /**
     * @inheritDoc
     */
    public function enum(string $abstract)
    {
        return Arr::get($this->enums, $abstract);
    }

    /**
     * @inheritDoc
     */
    public function getEnumBindings(): Collection
    {
        return collect($this->enums);
    }

    /**
     * @inheritdoc
     */
    public function getRequestBindings(): Collection
    {
        return collect($this->requests);
    }

    /**
     * @inheritdoc
     */
    public function helper($name, $arguments = [])
    {
        return $this->app->make('concord.helpers.' . $name, $arguments);
    }

    /**
     * @inheritdoc
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * @inheritdoc
     */
    public function short($name)
    {
        return Arr::get($this->shorts, "$name.class");
    }

    public function hookInto(HookEvent $event, callable $callback, array|string $filter = null): void
    {
        $this->hooks->register($event, $callback, $filter);
    }

    /**
     * Resets the proxy class to ensure no stale instance gets stuck
     *
     * @param string $proxyClass
     */
    protected function resetProxy($proxyClass)
    {
        $proxyClass::__reset();
    }

    /**
     * Register a model/enum/request shorthand
     *
     * @param string    $abstract
     * @param string    $type
     */
    protected function registerShort($abstract, $type)
    {
        $this->shorts[shorten($abstract)] = [
            'type' => $type,
            'class' => $abstract
        ];
    }

    /**
     * Merge the module's config with the existing config
     *
     * @param string $moduleId
     * @param array  $config
     */
    protected function mergeModuleConfig(string $moduleId, array $config)
    {
        $current = $this->app['config']->get($moduleId);
        $final = $this->hooks->happening(
            HookEvent::LOADING_CONFIGURATION(),
            $moduleId,
            is_array($current) ? array_merge($current, $config) : $config,
        );

        if (!empty($config)) {
            $this->app['config']->set($moduleId, $final);
        }
    }
}
