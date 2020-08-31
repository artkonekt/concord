<?php
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

abstract class BaseBoxServiceProvider extends BaseServiceProvider
{
    protected $configFileName = 'box.php';

    protected static $_kind = 'box';

    public function register()
    {
        parent::register();

        $modules = $this->config("modules");
        $modules = $modules ?: [];

        foreach ($modules as $module => $configuration) {
            if (is_int($module) && is_string($configuration)) { // means no configuration was set for module
                $module        = $configuration;
                $configuration = $this->getDefaultModuleConfiguration();
            } else {
                $configuration = array_merge(
                    $this->getDefaultModuleConfiguration(),
                    is_array($configuration) ? $configuration : []
                );
                $configuration = array_replace_recursive($configuration, $this->getCascadeModuleConfiguration());
            }

            $this->concord->registerModule($module, $configuration);
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

    /**
     * Returns the default configuration settings for modules loaded within boxes
     *
     * @return array
     */
    protected function getDefaultModuleConfiguration()
    {
        return [
            'implicit'   => true,
            'migrations' => $this->areMigrationsEnabled(),
            'views'      => $this->areViewsEnabled(),
            'routes'     => $this->areRoutesEnabled()
        ];
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
