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


namespace Konekt\Concord\Tests\Unit;


use Konekt\Concord\Module\Kind;
use Konekt\Concord\Tests\TestCase;

class ModuleTest extends TestCase
{
    public function testMinimalModule()
    {
        $modules = $this->app->concord
            ->getModules()
            ->keyBy(function($module) {
                return $module->getId();
            });

        $this->assertTrue($modules->has('minimal'), 'Module `minimal` should be registered');

        $minimalModule = $modules->get('minimal');
        $manifest = $minimalModule->getManifest();
        $this->assertEquals('2.3.0', $manifest->getVersion());
        $this->assertEquals('Minimal', $manifest->getName());
        $this->assertTrue($manifest->getKind()->equals(Kind::MODULE()));
    }

}