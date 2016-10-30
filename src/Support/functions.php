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
use Konekt\Concord\Contracts\ConcordInterface;

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
 * @return ConcordInterface
 */
function concord()
{
    return App::make('concord');
}
