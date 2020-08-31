<?php
/**
 * Contains the RouteRegistrar class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-06-05
 *
 */

namespace Konekt\Concord\Routing;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Contracts\Module;

class RouteRegistrar
{
    /** @var Module */
    private $module;

    /** @var Convention */
    private $convention;

    public function __construct(Module $module, Convention $convention)
    {
        $this->module     = $module;
        $this->convention = $convention;
    }

    public function registerAllRoutes()
    {
        $routeFiles = collect(File::glob($this->getRoutesFolder() . '/*.php'))->map(function ($file) {
            return File::name($file);
        })->all();

        $this->registerRoutes($routeFiles);
    }

    public function registerRoutes(array $files, array $config = [])
    {
        $path = $this->getRoutesFolder();

        if (is_dir($path)) {
            $routes = $files;

            foreach ($routes as $route) {
                Route::group(
                    [
                        'namespace'  => Arr::get($config, 'namespace', $this->getDefaultRouteNamespace()),
                        'prefix'     => Arr::get($config, 'prefix', $this->module->shortName()),
                        'as'         => Arr::get($config, 'as', $this->module->shortName() . '.'),
                        'middleware' => Arr::get($config, 'middleware', ['web'])
                    ],
                    sprintf('%s/%s.php', $path, $route)
                );
            }
        }
    }

    /**
     * Returns the default namespace for routes/controllers within a box/module
     *
     * @return string
     */
    private function getDefaultRouteNamespace()
    {
        return sprintf(
            '%s\\%s',
            $this->module->getNamespaceRoot(),
            str_replace('/', '\\', $this->convention->controllersFolder())
        );
    }

    private function getRoutesFolder(): string
    {
        return $this->module->getBasePath() . '/' . $this->convention->routesFolder();
    }
}
