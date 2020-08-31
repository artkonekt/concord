<?php
/**
 * Contains the RouteModelTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-08-31
 *
 */

namespace Konekt\Concord\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Konekt\Concord\Tests\Modules\ModuleWithProductModel\Providers\ModuleServiceProvider as ModuleWithProduct;
use Konekt\Concord\Tests\TestCase;

class RouteModelTest extends TestCase
{
    /** @test */
    public function route_models_are_registered_by_default()
    {
        $this->assertNotNull(Route::getBindingCallback('product'));
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            ModuleWithProduct::class
        ]);
    }
}
