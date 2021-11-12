<?php

declare(strict_types=1);

/**
 * Contains the BaseBoxServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-29
 *
 */

namespace Konekt\Concord;

use Konekt\Concord\Concerns\LoadsSubmodules;

abstract class BaseBoxServiceProvider extends BaseServiceProvider
{
    use LoadsSubmodules;

    protected $configFileName = 'box.php';

    protected static $_kind = 'box';

    public function register()
    {
        parent::register();

        $modules = $this->config("modules", []);

        if (is_array($modules)) {
            $this->loadSubModules($modules);
        }
    }

    public function boot()
    {
        parent::boot();

        $this->publishOwnMigrationsInASeparateGroup();
        $this->publishAllSubModuleMigrations();
    }

    /**
     * Returns the "cascade" configuration: the "apply to all submodules" config override array
     *
     * @return array
     */
    protected function getCascadeModuleConfiguration(): array
    {
        $result = $this->config('cascade_config', []);

        return is_array($result) ? $result : [];
    }

    private function publishAllSubModuleMigrations(): void
    {
        $folder = '/' . $this->convention->migrationsFolder();
        $moduleMigrationPaths = [
            $this->getBasePath() . $folder => database_path('migrations')
        ];
        foreach ($this->config("modules", []) as $moduleClass => $config) {
            $module = $this->concord->module($this->getModuleId($moduleClass));
            $moduleMigrationPaths[$module->getBasePath() . $folder] = database_path('migrations');
        }

        $this->publishes($moduleMigrationPaths, 'migrations');
    }

    private function publishOwnMigrationsInASeparateGroup()
    {
        $this->publishes([
            $this->getBasePath() . '/' . $this->convention->migrationsFolder() =>
                database_path('migrations')
        ], 'own-migrations-only');
    }
}
