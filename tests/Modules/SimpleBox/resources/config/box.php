<?php

declare(strict_types=1);

use Konekt\Concord\Tests\Modules\SimpleBoxSubmodule1\Providers\ModuleServiceProvider as SubModule1;
use Konekt\Concord\Tests\Modules\SimpleBoxSubmodule2\Providers\ModuleServiceProvider as SubModule2;

return [
    'modules' => [
        SubModule1::class => [],
        SubModule2::class => [],
    ]
];
