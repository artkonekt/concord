<?php

declare(strict_types=1);

/**
 * Contains the ModuleIdGeneratorTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-13
 *
 */

namespace Konekt\Concord\Tests\Unit;

use Konekt\Concord\Conventions\ConcordDefault;
use Konekt\Concord\Utils\ModuleIdGenerator;
use PHPUnit\Framework\TestCase;

class ModuleIdGeneratorTest extends TestCase
{
    /**
     * @test
     * @dataProvider moduleIdProvider
     */
    public function it_properly_generates_a_module_id($class, $id)
    {
        $this->assertEquals($id, ModuleIdGenerator::idOfClass($class, new ConcordDefault()));
    }

    public function moduleIdProvider(): array
    {
        return [
            ['Konekt\Acl\Providers\ModuleServiceProvider', 'konekt.acl'],
            ['\Konekt\Acl\Providers\ModuleServiceProvider', 'konekt.acl'],
            ['VenDor\WTF\Providers\ModuleServiceProvider', 'vendor.wtf'],
            ['App\Modules\Billing\Providers\ModuleServiceProvider', 'billing'],
            ['\App\Modules\Order\Providers\ModuleServiceProvider', 'order'],
            ['\App\Modules\coyote\Providers\ModuleServiceProvider', 'coyote'],
            ['App\Modules\WordPress\Providers\ModuleServiceProvider', 'wordpress'],
            ['App\Modules\GreatModules\Providers\ModuleServiceProvider', 'greatmodules'],
            ['Modules\StartModules\Providers\ModuleServiceProvider', 'startmodules'],
            ['\Modules\StartModules\Providers\ModuleServiceProvider', 'startmodules'],
            ['Modules\Modulestar\Providers\ModuleServiceProvider', 'modulestar'],
            ['\Modules\Modulestar\Providers\ModuleServiceProvider', 'modulestar'],
            ['App\Modules\Moduleshit\Providers\ModuleServiceProvider', 'moduleshit']
        ];
    }
}
