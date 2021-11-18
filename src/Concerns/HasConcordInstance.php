<?php

declare(strict_types=1);

/**
 * Contains the HasConcordInstance trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-18
 *
 */

namespace Konekt\Concord\Concerns;

use Konekt\Concord\Contracts\Concord;

trait HasConcordInstance
{
    protected Concord $concord;
}
