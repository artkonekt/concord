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

    array_walk($parts, function (&$part) {
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

    array_walk($parts, function (&$part) {
        $part = studly_case($part);
    });

    return implode('\\', $parts);
}

/**
 * Returns a standard module name based on the module provider's classname
 *
 * Eg.: '\Vendor\Module\Providers\ModuleServiceProvider' -> 'vendor.module'
 *      'App\Modules\Billing' -> 'billing'
 *
 * @param string $classname
 * @param null|\Konekt\Concord\Contracts\Convention   $convention
 *
 * @return string
 */
function concord_module_id($classname, $convention = null)
{
    $convention    = $convention ?: concord()->getConvention();
    $modulesFolder = $convention->modulesFolder();
    // Check if '\Modules\' is part of the namespace
    $p = strrpos($classname, "\\$modulesFolder\\");
    // if no \Modules\, but starts with 'Modules\' that's also a match
    $p = false === $p ? strpos($classname, "$modulesFolder\\") : $p;
    if (false !== $p) {
        $parts           = explode('\\', substr($classname, $p + strlen($modulesFolder) + 1));
        $vendorAndModule = empty($parts[0]) ? array_only($parts, 1) : array_only($parts, 0);
    } else {
        $parts           = explode('\\', $classname);
        $vendorAndModule = empty($parts[0]) ? array_only($parts, [1,2]) : array_only($parts, [0,1]);
    }

    array_walk($vendorAndModule, function (&$part) {
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
 * @return object|null
 */
function helper($name, $arguments = [])
{
    return concord()->helper($name, $arguments);
}

/**
 * Returns the concord instance
 *
 * @return Concord
 */
function concord()
{
    return app('concord');
}

/**
 * Returns the classname shortened (no namespace, base class name only, snake_case
 *
 * @param string $classname
 *
 * @return string
 */
function shorten($classname)
{
    return snake_case(class_basename($classname));
}


/**
 * Shorthand function for returning an enum object by it's short name
 *
 * @param string    $shortname  The short name of the enum
 * @param mixed     $value      The value to create the enum with
 *
 * @return \Konekt\Enum\Enum
 */
function enum($shortname, $value = null)
{
    $abstract = concord()->short($shortname);
    if ($abstract && $class = concord()->enum($abstract)) {
        return new $class($value);
    }
}
