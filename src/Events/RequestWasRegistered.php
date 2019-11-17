<?php
/**
 * Contains the RequestWasRegistered class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-15
 *
 */

namespace Konekt\Concord\Events;

class RequestWasRegistered
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
