<?php

declare(strict_types=1);

/**
 * Contains the ExtWeatherStatus class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-18
 *
 */

namespace Konekt\Concord\Tests\Feature\Enums;

use Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Models\WeatherStatus;

class ExtWeatherStatus extends WeatherStatus
{
    public const MEH = 'meh';
}
