<?php

declare(strict_types=1);

/**
 * Contains the WeatherStatus class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-18
 *
 */

namespace Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Models;

use Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Contracts\WeatherStatus as WeatherStatusContract;
use Konekt\Enum\Enum;

class WeatherStatus extends Enum implements WeatherStatusContract
{
    public const GOOD = 'good';
    public const BAD = 'bad';
}
