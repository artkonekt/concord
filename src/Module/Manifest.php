<?php
/**
 * Contains the Module.php class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */


namespace Konekt\Concord\Module;


class Manifest
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $version;

    public function __construct($name, $version)
    {
        $this->name    = $name;
        $this->version = $version;
    }

    /**
     * Returns the module name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the module version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

}