<?php
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

use Konekt\Concord\Tests\Modules\ModuleWithEnum\Models\WeatherStatus;

class ExtWeatherStatus extends WeatherStatus
{
    const MEH  = 'meh';
}
