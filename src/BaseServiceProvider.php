<?php
/**
 * Contains the BaseServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-29
 *
 */


namespace Konekt\Concord;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Konekt\Concord\Contracts\Concord as ConcordContract;
use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Contracts\Module;
use Konekt\Concord\Module\Manifest;
use Konekt\Concord\Module\Kind;
use ReflectionClass;


abstract class BaseServiceProvider extends ServiceProvider implements Module
{
    /** @var  string */
    protected $basePath;

    /** @var  Manifest */
    protected $manifest;

    /** @var  string */
    protected $namespaceRoot;

    /** @var  string */
    protected $id;

    /** @var  array */
    protected $models = [];

    /** @var  ConcordContract */
    protected $concord;

    /** @var  Convention */
    protected $convention;

    /**
     * ModuleServiceProvider class constructor
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->concord       = $app->make(ConcordContract::class); // retrieve the concord singleton
        $this->convention    = $this->concord->getConvention(); // storing to get rid of train wrecks
        $this->basePath      = dirname(dirname((new ReflectionClass(static::class))->getFileName()));
        $this->namespaceRoot = str_replace('\\Providers\\ModuleServiceProvider', '', static::class);
        $this->id            = $this->getModuleId();
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        if ($this->config('migrations', true)) {
            $this->registerMigrations();
        }

        if ($this->config('models', true)) {
            $this->registerModels();
        }

        if ($this->config('views', true)) {
            $this->registerViews();
        }

        if ($this->config('routes', true)) {
            $this->registerRoutes();
        }
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Returns module configuration value(s)
     *
     * @param string $key If left empty, the entire module configuration gets retrieved
     * @param null   $default
     *
     * @return mixed
     */
    public function config(string $key = null, $default = null)
    {
        $key = $key ? sprintf('%s.%s', $this->getId(), $key) : $this->getId();

        return config($key, $default);
    }


    /**
     * @return Manifest
     */
    public function getManifest(): Manifest
    {
        if (!$this->manifest) {
            $data = include($this->basePath . '/' . $this->convention->manifestFile());

            extract($data);
            $kind = isset($kind) ? $kind : Kind::MODULE();

            $this->manifest = new Manifest($name, $version, $kind);
        }

        return $this->manifest;
    }

    /**
     * Returns the root folder on the filesystem containing the module
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Returns the folder where the module/box configuration files are
     *
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->getBasePath() . '/' . $this->convention->configFolder();

    }

    /**
     * Returns the module's root (topmost) namespace
     *
     * @return string
     */
    public function getNamespaceRoot(): string
    {
        return $this->namespaceRoot;
    }

    /**
     * Returns the short (abbreviated) name of the module
     * E.g. Konekt\AppShell => app_shell
     */
    public function shortName()
    {
        $id = $this->getModuleId();
        $p  = strrpos($id, '.');

        return $p ? substr($id, $p + 1) : $id;
    }


    /**
     * Returns a standard module name based on the module provider's classname
     *
     * Eg.: '\Vendor\Module\Services\ModuleServiceProvider' -> 'vendor.module'
     *
     * @param string    $classname
     *
     * @see concord_module_id
     *
     * @return string
     */
    protected function getModuleId($classname = null)
    {
        return concord_module_id($classname ?: static::class);
    }

    /**
     * Register the module's migrations
     */
    protected function registerMigrations()
    {
        $path = $this->getBasePath() . '/' . $this->convention->migrationsFolder();

        if ($this->app->runningInConsole() && is_dir($path)) {
            $this->loadMigrationsFrom($path);
        }
    }

    /**
     * Register models in a box/module
     */
    protected function registerModels()
    {
        foreach ($this->models as $key => $model) {
            $contract = is_string($key) ? $key : $this->convention->contractForModel($model);
            $this->concord->registerModel($contract, $model);
        }

    }

    /**
     * Register routes in a box/module
     *
     * @param array|null $only  if an array is passed, only the routes in the array will be registered
     */
    protected function registerRoutes($only = null)
    {
        $path = $this->getBasePath() . '/' . $this->convention->routesFolder();

        if (is_dir($path)) {

            $routes = is_array($only) ? $only : collect(File::glob($path . '/*.php'))->map(function ($file) {
                return File::name($file);
            })->all();

            foreach ($routes as $route) {
                Route::group(
                    [
                        'namespace'  => $this->config('routes.namespace', $this->getDefaultRouteNamespace()),
                        'prefix'     => $this->config('routes.prefix', $this->shortName()),
                        'as'         => $this->config('routes.as', $this->shortName() . '.'),
                        'middleware' => $this->config('routes.middleware', ['web'])
                    ],
                    sprintf('%s/%s.php', $path, $route)
                );
            }
        }
    }

    /**
     * Register the views folder, in a separate namespace
     */
    protected function registerViews()
    {
        $path      = $this->getBasePath() . '/' . $this->convention->viewsFolder();
        $namespace = $this->config('views.namespace', $this->shortName());

        if(is_dir($path)) {
            $this->loadViewsFrom($path, $namespace);
        }
    }

    /**
     * Returns the default namespace for routes/controllers within a box/module
     *
     * @return string
     */
    protected function getDefaultRouteNamespace()
    {
        return sprintf('%s\\%s',
            $this->getNamespaceRoot(),
            str_replace('/', '\\', $this->convention->controllersFolder())
        );
    }

}