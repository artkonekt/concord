<?php
/**
 * Contains the AbstractModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */


namespace Konekt\Concord;


use Illuminate\Support\ServiceProvider;
use Konekt\Concord\Module\Manifest;
use Konekt\Concord\Module\Kind;
use ReflectionClass;

/**
 * Class AbstractModuleServiceProvider is the abstract class all concord modules have to extend.
 *
 * This will be the main entry point for the module.
 * Nevertheless it's a normal Laravel Service Provider class.
 *
 */
abstract class AbstractModuleServiceProvider extends ServiceProvider
{
    /** @var  string */
    protected $basePath;

    /** @var  Manifest */
    protected $manifest;

    /** @var  string */
    protected $namespaceRoot;

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
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        $this->registerMigrations();
    }

    public function getManifest()
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
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Returns the module's root (topmost) namespace
     *
     * @return string
     */
    public function getNamespaceRoot()
    {
        return $this->namespaceRoot;
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