<?php
/**
 * Contains the Module Manifest class.
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

    /** @var  Kind */
    protected $kind;

    public function __construct($name, $version, $kind)
    {
        $this->name    = $name;
        $this->version = $version;
        $this->kind    = $kind;
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

    /**
     * Returns what kind of module this is (module or box)
     *
     * @return Kind
     */
    public function getKind()
    {
        return $this->kind;
    }

}