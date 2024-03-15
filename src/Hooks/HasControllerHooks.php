<?php

declare(strict_types=1);

/**
 * Contains the HasControllerHooks trait.
 *
 * @copyright   Copyright (c) 2024 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-03-15
 *
 */

namespace Konekt\Concord\Hooks;

trait HasControllerHooks
{
    /** @var ControllerHook[] */
    private static array $controllerHooks = [];

    public static function hookInto(string ...$actions): ControllerHook
    {
        $hook = new ControllerHook();

        foreach ($actions as $action) {
            $method = static::class . '::' . $action;
            self::$controllerHooks[$method] ??= [];
            self::$controllerHooks[$method][] = $hook;
        }

        return $hook;
    }

    protected function processViewData(string $method, array $data): array
    {
        $result = $data;
        foreach (self::$controllerHooks[$method] ?? [] as $hook) {
            $result = $hook->onInject($result);
        }

        return $result;
    }
}
