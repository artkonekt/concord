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
                $configuration = array_merge($this->getDefaultModuleConfiguration(),
                    is_array($configuration) ? $configuration : []);
            }

            $this->concord->registerModule($module, $configuration);
        }
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
            'migrations' => true,
            'views'      => true,
            'routes'     => true
        ];
    }
}
