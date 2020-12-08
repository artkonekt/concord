<?php

declare(strict_types=1);

/**
 * Contains the ProductType class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-08
 *
 */

namespace Konekt\Concord\Tests\Modules\ModuleWithProductModel\Models;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Tests\Modules\ModuleWithProductModel\Contracts\ProductType as ProductTypeContract;

class ProductType extends Model implements ProductTypeContract
{

}
