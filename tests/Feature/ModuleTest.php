<?php

declare(strict_types=1);

/**
 * Contains the ModuleTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-13
 *
 */

namespace Konekt\Concord\Tests\Feature;

use Konekt\Concord\Contracts\Module;
use Konekt\Concord\Module\Kind;
use Konekt\Concord\Tests\ExampleModules\Minimal\Providers\ModuleServiceProvider as MinimalModule;
use Konekt\Concord\Tests\TestCase;

class ModuleTest extends TestCase
{
    /** @test */
    public function minimal_module_can_properly_be_loaded()
    {
        $modules = $this->concord->getModules();

        $this->assertTrue($modules->has('minimal'), 'Module `minimal` should be registered');

        /** @var Module $minimalModule */
        $minimalModule = $modules->get('minimal');
        $this->assertTrue($minimalModule->getKind()->equals(Kind::MODULE()));

        $this->assertEquals('2.3.0', $minimalModule->getVersion());
        $this->assertEquals('Minimal', $minimalModule->getName());
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            MinimalModule::class
        ]);
    }
}
