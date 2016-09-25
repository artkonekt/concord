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
