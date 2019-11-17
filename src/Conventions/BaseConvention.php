<?php
/**
 * Contains the BaseConvention class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-14
 *
 */

namespace Konekt\Concord\Conventions;

/**
 * Contains some utility classes to be used by concrete convention classes
 */
abstract class BaseConvention
{
    /**
     * Returns the namespace part of a class
     *
     * @param string $class
     *
     * @return string
     */
    protected function getNamespace(string $class)
    {
        return $this->oneLevelUp($class);
    }

    /**
     * Chops the last part of the namespace eg \a\b\c => \a\b
     *
     * @param string $namespace
     *
     * @return bool|string
     */
    protected function oneLevelUp(string $namespace)
    {
        if ($pos = strrpos($namespace, '\\')) {
            return substr($namespace, 0, $pos);
        }

        return '';
    }
}
