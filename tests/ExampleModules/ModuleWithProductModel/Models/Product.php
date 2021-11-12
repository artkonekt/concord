<?php

declare(strict_types=1);

/**
 * Contains the Product class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-08-31
 *
 */

namespace Konekt\Concord\Tests\ExampleModules\ModuleWithProductModel\Models;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Tests\ExampleModules\ModuleWithProductModel\Contracts\Product as ProductContract;

class Product extends Model implements ProductContract
{
}
