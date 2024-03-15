<?php

declare(strict_types=1);

/**
 * Contains the ControllerHook class.
 *
 * @copyright   Copyright (c) 2024 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-03-15
 *
 */

namespace Konekt\Concord\Hooks;

class ControllerHook
{
    /** @var callable $injectionCallback */
    protected $injectionCallback;

    public function viewDataInjection(callable $callback): void
    {
        $this->injectionCallback = $callback;
    }

    public function onInject(array $viewData): array
    {
        return call_user_func($this->injectionCallback, $viewData);
    }
}
