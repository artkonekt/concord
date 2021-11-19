<?php

declare(strict_types=1);

/**
 * Contains the Concord facade class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-10-30
 *
 */

namespace Konekt\Concord\Facades;

use Illuminate\Support\Facades\Facade;
use Konekt\Concord\Hooks\HookEvent;

/**
 * @method static void hookInto(HookEvent $event, callable $callback, string|array $filter = null)
 */
class Concord extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'concord';
    }
}
