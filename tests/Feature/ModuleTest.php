<?php
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

use Konekt\Concord\Module\Kind;
use Konekt\Concord\Tests\Modules\Minimal\Providers\ModuleServiceProvider as MinimalModule;
use Konekt\Concord\Tests\TestCase;

class ModuleTest extends TestCase
{
    /**
     * @test
     */
    public function minimal_module_can_properly_be_loaded()
    {
        $modules = $this->concord->getModules();

        $this->assertTrue($modules->has('minimal'), 'Module `minimal` should be registered');

        $minimalModule = $modules->get('minimal');
        $manifest      = $minimalModule->getManifest();
        $this->assertEquals('2.3.0', $manifest->getVersion());
        $this->assertEquals('Minimal', $manifest->getName());
        $this->assertTrue($manifest->getKind()->equals(Kind::MODULE()));
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
