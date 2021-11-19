<?php

declare(strict_types=1);

/**
 * Contains the HookEvent class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-19
 *
 */

namespace Konekt\Concord\Hooks;

use Konekt\Enum\Enum;

/**
 * @method static HookEvent LOADING_CONFIGURATION()
 */
final class HookEvent extends Enum
{
    public const LOADING_CONFIGURATION = 'loading_configuration';
}
