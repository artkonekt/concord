<?php

declare(strict_types=1);

/**
 * Contains the ConfigHookTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-19
 *
 */

namespace Konekt\Concord\Tests\Feature\Hooks;

use Konekt\Concord\Facades\Concord;
use Konekt\Concord\Hooks\HookEvent;
use Konekt\Concord\Tests\ExampleModules\SimpleBox\Providers\ModuleServiceProvider as SimpleBox;
use Konekt\Concord\Tests\TestCase;

class ConfigHookTest extends TestCase
{
    private bool $hookWasCalled = false;

    protected function setUp(): void
    {
        parent::setUp();
        Concord::hookInto(
            HookEvent::LOADING_CONFIGURATION(),
            fn () => $this->hookWasCalled = true,
        );
    }

    /** @test */
    public function it_is_possible_to_hook_into_the_module_configuration_process()
    {
        $this->assertTrue($this->hookWasCalled);
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            SimpleBox::class
        ]);
    }
}
