<?php
/**
 * Contains the WeatherStatus class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-18
 *
 */

namespace Konekt\Concord\Tests\Modules\ModuleWithEnum\Models;

use Konekt\Concord\Tests\Modules\ModuleWithEnum\Contracts\WeatherStatus as WeatherStatusContract;
use Konekt\Enum\Enum;

class WeatherStatus extends Enum implements WeatherStatusContract
{
    const GOOD = 'good';
    const BAD  = 'bad';
}
