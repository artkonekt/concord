<?php

declare(strict_types=1);

namespace Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Concord\Tests\ExampleModules\ModuleWithEnum\Models\WeatherStatus;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected static ?string $moduleId = 'module_with_enum';

    protected array $enums = [
        WeatherStatus::class
    ];
}
