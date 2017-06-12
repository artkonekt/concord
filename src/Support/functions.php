<?php
/**
 * Contains the Concord helper functions
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-09-25
 *
 */
use Konekt\Concord\Contracts\Concord;

/**
 * Converts a fully qualified classname to a string (backslashes to dots, parts to snake case)
 *
 * Eg.: '\App\Services\BamBamService' -> 'app.services.bam_bam_service'
 *
 * @param string    $classname
 *
 * @return string
 */
function classpath_to_slug($classname)
{
    $parts = explode('\\', $classname);
    // Remove first part if empty ie. begins with \
    if (empty($parts[0])) {
        $parts = array_except($parts, 0);
    }
    // Remove last part if empty ie. ends to \
    if (empty($parts[count($parts) - 1])) {
        $parts = array_except($parts, count($parts) - 1);
    }

    array_walk($parts, function(&$part) {
        $part = snake_case($part);
    });

    return implode('.', $parts);
}

/**
 * Counterpart of classpath_to_str, that converts the string back to a fully qualified classname
 *
 * Eg.: 'app.services.bam_bam_service' -> '\App\Services\BamBamService'
 *
 * @see classpath_to_str()
 *
 * @param string    $str
 *
 * @return string
 */
function slug_to_classpath($str)
{
    $parts = explode('.', $str);

    array_walk($parts, function(&$part) {
        $part = studly_case($part);
    });

    return implode('\\', $parts);

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
function concord_module_id($classname)
{
    $parts = explode('\\', $classname);

    $vendorAndModule = empty($parts[0]) ? array_only($parts, [1,2]) : array_only($parts, [0,1]);

    array_walk($vendorAndModule, function(&$part) {
        $part = snake_case($part);
    });

    return implode('.', $vendorAndModule);
}

/**
 * Shortcut function for returning helper instances by their name
 *
 * @param string    $name       The name of the helper
 * @param array     $arguments  Optional arguments to pass to the helper class
 *
 * @return
 */
function helper($name, $arguments = [])
{
    return App::make('concord.helper')->get($name, $arguments);
}

/**
 * Returns the concord instance
 *
 * @return Concord
 */
function concord()
{
    return App::make('concord');
}

if (!function_exists('__')) {

    /**
     * Gettext fallback function, so that it doesn't break functionality
     * Note: xinax/laravel-gettext should be used
     *
     * @todo: make sure it doesn't hit the loader earlier than laravel-gettext does
     *
     * @param      $message
     * @param null $args
     *
     * @return string
     */
    function __($message, $args = null)
    {
        if (!empty($args) && !is_array($args)) {
            $args = array_slice(func_get_args(), 1);
        }

        $message = vsprintf($message, $args);

        return $message;
    }
}
