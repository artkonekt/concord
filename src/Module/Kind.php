<?php

declare(strict_types=1);

/**
 * Contains the Module Kind class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-26
 *
 */

namespace Konekt\Concord\Module;

use Konekt\Enum\Enum;

class Kind extends Enum
{
    public const __DEFAULT = self::MODULE;

    public const MODULE = 'module';
    public const BOX = 'box';

    protected static $labels = [
        self::MODULE => 'Module',
        self::BOX => 'Box'
    ];
}
