<?php

declare(strict_types=1);

/**
 * Contains the ModuleServiceProviderTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-13
 *
 */

namespace Konekt\Concord\Tests\Unit;

use Konekt\Concord\Contracts\Module;
use Konekt\Concord\Tests\Dummies\ExampleModuleServiceProvider;
use Konekt\Concord\Tests\TestCase;

class ModuleServiceProviderTest extends TestCase
{
    /** @test */
    public function it_has_a_static_id()
    {
        $this->assertNotEmpty(ExampleModuleServiceProvider::getId());
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $module = new ExampleModuleServiceProvider($this->app);

        $this->assertInstanceOf(Module::class, $module);
    }
}
