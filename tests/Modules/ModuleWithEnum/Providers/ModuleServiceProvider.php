<?php

namespace Konekt\Concord\Tests\Modules\ModuleWithEnum\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Concord\Tests\Modules\ModuleWithEnum\Models\WeatherStatus;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $enums = [
        WeatherStatus::class
    ];
}
