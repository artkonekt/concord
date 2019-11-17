<?php
/**
 * Contains the BaseModuleServiceProvider class.
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
abstract class BaseModuleServiceProvider extends BaseServiceProvider
{
    protected $configFileName = 'module.php';

    protected static $_kind = 'module';
}
