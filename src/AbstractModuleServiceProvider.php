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



/**
 * Class AbstractModuleServiceProvider is the abstract class all concord modules have to extend.
 *
 * This will be the main entry point for the module.
 * Nevertheless it's a normal Laravel Service Provider class.
 *
 */
abstract class AbstractModuleServiceProvider extends AbstractBaseServiceProvider
{

    public function register()
    {
        $cfgFile = sprintf('%s/module.php', $this->getConfigPath());

        if (file_exists($cfgFile)) {
            $this->mergeConfigFrom($cfgFile, $this->getId());
        }

    }
    
    /**
     * @inheritdoc
     */
    public function boot()
    {
        if ($this->config('migrations', true)) {
            $this->registerMigrations();
        }
    }

}