<?php
/**
 * Contains the AbstractBaseServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-29
 *
 */


namespace Konekt\Concord;

use Illuminate\Support\ServiceProvider;
use Konekt\Concord\Contracts\ModuleConfigurationInterface;
use Konekt\Concord\Contracts\ModuleInterface;
use Konekt\Concord\Module\Manifest;
use Konekt\Concord\Module\Kind;
use ReflectionClass;


class AbstractBaseServiceProvider extends ServiceProvider implements ModuleInterface
{
    /** @var  string */
    protected $basePath;

    /** @var  Manifest */
    protected $manifest;

    /** @var  string */
    protected $namespaceRoot;

    /** @var  string */
    protected $id;


    /**
     * ModuleServiceProvider class constructor
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->basePath      = dirname(dirname((new ReflectionClass(static::class))->getFileName()));
        $this->namespaceRoot = str_replace('\\Providers\\ModuleServiceProvider', '', static::class);
        $this->id            = $this->getModuleId();
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
     * @param string $key   If left empty, the entire module configuration gets retrieved
     *
     * @return mixed
     */
    public function config(string $key = null)
    {
        $key = $key ? sprintf('%s.%s', $this->getId(), $key) : $this->getId();

        return config($key);
    }


    public function getManifest(): Manifest
    {
        if (!$this->manifest) {
            $data = include($this->basePath . '/resources/manifest.php' );

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
        return $this->getBasePath() . '/resources/config';

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
     * Returns a standard module name based on the module provider's classname
     *
     * Eg.: '\Vendor\Module\Services\ModuleServiceProvider' -> 'vendor.module'
     *
     * @param string    $classname
     *
     * @return string
     */
    protected function getModuleId($classname = null)
    {
        $parts = explode('\\', $classname ?: static::class);

        $vendorAndModule = empty($parts[0]) ? array_only($parts, [1,2]) : array_only($parts, [0,1]);

        array_walk($vendorAndModule, function(&$part) {
            $part = snake_case($part);
        });

        return implode('.', $vendorAndModule);
    }

    /**
     * Register the module's migrations
     */
    protected function registerMigrations()
    {
        $path = $this->getBasePath() . '/resources/database/migrations';

        if ($this->app->runningInConsole() && is_dir($path)) {
            $this->loadMigrationsFrom($path);
        }
    }

}