<?php

declare(strict_types=1);

namespace Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Models\WeatherStatus;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $enums = [
        WeatherStatus::class
    ];
}
