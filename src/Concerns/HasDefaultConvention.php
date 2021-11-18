<?php

declare(strict_types=1);

/**
 * Contains the HasDefaultConvention trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-13
 *
 */

namespace Konekt\Concord\Concerns;

use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Conventions\ConcordDefault;

trait HasDefaultConvention
{
    private static ?ConcordDefault $convention = null;

    public static function getConvention(): Convention
    {
        if (null === static::$convention) {
            static::$convention = new ConcordDefault();
        }

        return static::$convention;
    }
}
