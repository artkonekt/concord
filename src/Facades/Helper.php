<?php
/**
 * Contains the Helper facade class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-10-30
 *
 */

namespace Konekt\Concord\Facades;

use Illuminate\Support\Facades\Facade;

class Helper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'concord.helper';
    }
}
