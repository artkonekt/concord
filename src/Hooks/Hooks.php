<?php

declare(strict_types=1);

/**
 * Contains the Hooks class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-19
 *
 */

namespace Konekt\Concord\Hooks;

use Illuminate\Support\Collection;

final class Hooks
{
    private Collection $hooks;

    public function __construct()
    {
        $this->hooks = collect();
    }

    public function register(HookEvent $event, callable $callback, array|string $filter = null): void
    {
        /** @var array{event: HookEvent, callback: callable, filter: string|array|null} */
        $hook = [
            'event' => $event,
            'callback' => $callback,
            'filter' => $filter,
        ];

        $this->hooks->add($hook);
        dump('r', $this->hooks->all());
    }

    public function happening(HookEvent $event, string $moduleId, mixed $hookableArgument): mixed
    {
        dump('h', $this->hooks->all());
        $hooks = $this->hooks->filter(
            fn ($hook, $index) => $event->equals($hook['event']) && $this->theHookIsForTheModule($hook['filter'], $moduleId)
        );

        foreach ($hooks as $hook) {
            $hookableArgument = call_user_func($hook['callback'], $moduleId, $hookableArgument);
        }

        return $hookableArgument;
    }

    private function theHookIsForTheModule(array|string|null $filter, string $moduleId): bool
    {
        if (null === $filter) {
            return true;
        }

        if (is_string($filter)) {
            return $filter === $moduleId;
        }

        return in_array($moduleId, $filter);
    }
}
