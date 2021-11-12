<?php

declare(strict_types=1);

/**
 * Contains the LoadsSubmodules trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-11
 *
 */

namespace Konekt\Concord\Concerns;

use JetBrains\PhpStorm\ArrayShape;

trait LoadsSubmodules
{
    private function loadSubModules(array $modules): void
    {
        foreach ($modules as $module => $configuration) {
            if (is_int($module) && is_string($configuration)) { // means no configuration was set for module
                $module = $configuration;
                $configuration = $this->getDefaultSubModuleConfiguration();
            } else {
                $configuration = array_merge(
                    $this->getDefaultSubModuleConfiguration(),
                    is_array($configuration) ? $configuration : []
                );
                $configuration = array_replace_recursive($configuration, $this->getCascadeModuleConfiguration());
            }

            $this->concord->registerModule($module, $configuration);
        }
    }

    #[ArrayShape(['implicit' => "bool", 'migrations' => "mixed", 'views' => "mixed", 'routes' => "mixed"])] private function getDefaultSubModuleConfiguration(): array
    {
        return [
            'implicit' => true,
            'migrations' => $this->areMigrationsEnabled(),
            'views' => $this->areViewsEnabled(),
            'routes' => $this->areRoutesEnabled()
        ];
    }
}
