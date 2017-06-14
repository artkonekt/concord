<?php
/**
 * Contains the VersionTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-14
 *
 */


namespace Konekt\Concord\Tests\Feature;


use Artisan;
use Konekt\Concord\Concord;
use Konekt\Concord\Tests\TestCase;

class VersionTest extends TestCase
{
    public function testVersionCommandMatchesConst()
    {
        Artisan::call('concord:version');

        $this->assertEquals(Concord::VERSION, rtrim(Artisan::output()));
    }

}