<?php

declare(strict_types=1);

/**
 * Contains the HasModuleConfig trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-11
 *
 */

namespace Konekt\Concord\Concerns;

trait HasModuleConfig
{
    public function config(string $key = null, $default = null): mixed
    {
        $key = $key ? sprintf('%s.%s', $this->getId(), $key) : $this->getId();

        return config($key, $default);
    }

    public function areMigrationsEnabled(): bool
    {
        return (bool) $this->config('migrations', true);
    }

    public function areModelsEnabled(): bool
    {
        return (bool) $this->config('models', true);
    }

    public function areViewsEnabled(): bool
    {
        return (bool) $this->config('views', true);
    }

    public function areRoutesEnabled(): bool
    {
        return (bool) $this->config('routes', true);
    }

    abstract public function getId(): string;
}
