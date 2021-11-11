<?php

declare(strict_types=1);

/**
 * Contains the DefaultConfigTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-06-20
 *
 */

namespace Konekt\Concord\Tests\Feature;

use Konekt\Concord\Tests\Modules\SimpleBox\Providers\ModuleServiceProvider as SimpleBox;
use Konekt\Concord\Tests\TestCase;

class DefaultConfigTest extends TestCase
{
    /** @test */
    public function module_config_is_independent_of_parent_box_by_default()
    {
        $modules = $this->concord->getModules(true);
        $this->assertTrue($modules->has('simple_box_submodule1'), 'Module `simple_box_submodule1` should be registered');
        $this->assertTrue($modules->has('simple_box_submodule2'), 'Module `simple_box_submodule2` should be registered');

        $module1 = $this->concord->module('simple_box_submodule1');
        $module2 = $this->concord->module('simple_box_submodule2');

        $this->assertEquals('YES', $module1->config('some_key'));
        $this->assertEquals('SURE', $module2->config('some_key'));

        $this->assertTrue($module1->config('migrations'));
        $this->assertTrue($module2->config('migrations'));

        $this->assertEquals('Giovanni', $module1->config('parent.child_1'));
        $this->assertEquals('Francesco', $module1->config('parent.child_2'));

        $this->assertEquals('Fritz', $module2->config('parent.child_1'));
        $this->assertEquals('Schwarz', $module2->config('parent.child_2'));
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            SimpleBox::class
        ]);
    }
}
