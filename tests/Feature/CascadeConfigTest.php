<?php
/**
 * Contains the CascadeConfigTest class.
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

class CascadeConfigTest extends TestCase
{
    /** @test */
    public function box_config_can_be_cascaded_to_child_modules()
    {
        $module1 = $this->concord->module('simple_box_submodule1');
        $module2 = $this->concord->module('simple_box_submodule2');

        $this->assertEquals('NO!', $module1->config('some_key'));
        $this->assertEquals('NO!', $module2->config('some_key'));

        $this->assertFalse($module1->config('migrations'));
        $this->assertFalse($module2->config('migrations'));

        $this->assertEquals('George', $module1->config('parent.child_1'));

        $this->assertEquals('George', $module2->config('parent.child_1'));;
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            SimpleBox::class => [
                'cascade_config' => [
                    'migrations' => false,
                    'some_key' => 'NO!',
                    'parent' => [
                        'child_1' => 'George'
                    ]
                ]
            ]
        ]);
    }
}
