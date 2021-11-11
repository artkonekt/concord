<?php

declare(strict_types=1);

/**
 * Contains the RouteModelDisabledTest class.
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

class RouteModelDisabledTest extends TestCase
{
    /** @test */
    public function route_model_registration_can_be_disabled_via_config()
    {
        $this->assertNull(Route::getBindingCallback('product'));
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.register_route_models', false);
        $app['config']->set('concord.modules', [
            ModuleWithProduct::class
        ]);
    }
}
