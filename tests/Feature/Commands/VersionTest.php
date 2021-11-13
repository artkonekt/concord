<?php

declare(strict_types=1);

/**
 * Contains the VersionTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-14
 *
 */

namespace Konekt\Concord\Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use Konekt\Concord\Concord;
use Konekt\Concord\Tests\TestCase;

class VersionTest extends TestCase
{
    /** @test */
    public function the_output_matches_the_version_const_value()
    {
        Artisan::call('concord:version');

        $this->assertEquals(Concord::VERSION, rtrim(Artisan::output()));
    }
}
