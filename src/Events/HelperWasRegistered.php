<?php
/**
 * Contains the HelperWasRegistered class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-15
 *
 */

namespace Konekt\Concord\Events;

class HelperWasRegistered
{
    /** @var  string */
    public $name;

    /** @var  string */
    public $className;

    public function __construct($name, $class)
    {
        $this->name      = $name;
        $this->className = $class;
    }
}
