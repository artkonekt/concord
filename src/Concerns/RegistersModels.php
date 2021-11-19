<?php

declare(strict_types=1);

/**
 * Contains the RegistersModels trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-19
 *
 */

namespace Konekt\Concord\Concerns;

trait RegistersModels
{
    use HasConcordInstance;

    protected array $models = [];

    protected function registerModels()
    {
        foreach ($this->models as $key => $model) {
            $contract = is_string($key) ? $key : static::getConvention()->contractForModel($model);
            $this->concord->registerModel($contract, $model, config('concord.register_route_models', true));
        }
    }
}
