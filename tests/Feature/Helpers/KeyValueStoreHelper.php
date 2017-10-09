<?php
/**
 * Contains the KeyValueStoreHelper class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-13
 *
 */


namespace Konekt\Concord\Tests\Feature\Helpers;

class KeyValueStoreHelper
{
    private $registry = [];

    public function set($key, $value)
    {
        $this->registry[$key] = $value;
    }

    public function get($key)
    {
        return isset($this->registry[$key]) ? $this->registry[$key] : null;
    }
}
