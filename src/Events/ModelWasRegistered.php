<?php
/**
 * Contains the ModelWasRegistered class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-15
 *
 */

namespace Konekt\Concord\Events;

class ModelWasRegistered
{
    /** @var  string */
    public $abstract;

    /** @var  string */
    public $concrete;

    /** @var  bool */
    public $routeModelWasRegistered;

    public function __construct($abstract, $concrete, $routeModelWasRegistered)
    {
        $this->abstract                = $abstract;
        $this->concrete                = $concrete;
        $this->routeModelWasRegistered = $routeModelWasRegistered;
    }
}
