<?php
/**
 * Contains the HelperFactory class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-10-30
 *
 */


namespace Konekt\Concord\Helper;


use Illuminate\Contracts\Foundation\Application;

class HelperFactory
{
    /** @var  array */
    protected $helpers;

    /** @var  Application $app */
    protected $app;

    /**
     * HelperFactory constructor.
     *
     * @param array         $helpers The key/value combo of list of helpers eg. 'country' => 'App\\CountryHelper'
     * @param Application   $app
     */
    public function __construct($helpers, $app)
    {
        $this->helpers = $helpers;
        $this->app     = $app;
    }

    /**
     * Returns a specific helper instance by it's name
     *
     * @param $name
     * @param array $arguments
     *
     * @return null|object
     */
    public function get($name, $arguments = [])
    {
        $class = array_key_exists($name, $this->helpers) ? $this->helpers[$name] : false;

        return $class ? $this->app->make($class, $arguments) : null;
    }

}