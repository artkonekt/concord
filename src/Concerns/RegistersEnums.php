<?php

declare(strict_types=1);

/**
 * Contains the RegistersEnums trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-18
 *
 */

namespace Konekt\Concord\Concerns;

trait RegistersEnums
{
    use HasConcordInstance;

    protected array $enums = [];

    protected function registerEnums()
    {
        foreach ($this->enums as $key => $enum) {
            $contract = is_string($key) ? $key : static::getConvention()->contractForEnum($enum);
            $this->concord->registerEnum($contract, $enum);
        }
    }
}
