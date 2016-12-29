<?php
/**
 * Contains the AbstractBoxServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-29
 *
 */


namespace Konekt\Concord;


class AbstractBoxServiceProvider extends AbstractBaseServiceProvider
{

    public function register()
    {
        $cfgFile = sprintf('%s/box.php', $this->getConfigPath());

        if (file_exists($cfgFile)) {
            $this->mergeConfigFrom($cfgFile, $this->getId());
        }

        $modules = $this->config("modules");
        $modules = $modules ?: [];

        foreach ($modules as $module => $configuration) {
            if (is_array($configuration) && isset($configuration['implicit'])) {
                $implicit = $configuration['implicit'];
            } else {
                $implicit = true; // By default, modules loaded by boxes are implicit
            }

            $this->app['concord']->registerModule($module, $implicit);
        }

    }

}