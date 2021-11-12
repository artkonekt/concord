<?php

declare(strict_types=1);

/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-08-31
 *
 */

namespace Konekt\Concord\Tests\ExampleModules\ModuleWithProductModel\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Concord\Tests\ExampleModules\ModuleWithProductModel\Models\Product;
use Konekt\Concord\Tests\ExampleModules\ModuleWithProductModel\Models\ProductType;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        Product::class,
        ProductType::class,
    ];
}
