<?php
/**
 * Contains the EnumWasRegistered class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-15
 *
 */

namespace Konekt\Concord\Events;

/**
 * Event that gets fired in case an enum gets registered
 */
class EnumWasRegistered
{
    /** @var  string */
    public $abstract;

    /** @var  string */
    public $concrete;

    public function __construct($abstract, $concrete)
    {
        $this->abstract = $abstract;
        $this->concrete = $concrete;
    }
}
