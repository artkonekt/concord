<?php
/**
 * Contains the SupportFunctionsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-12
 *
 */


namespace Konekt\Concord\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitBaseTestCase;

class SupportFunctionsTest extends PHPUnitBaseTestCase
{

    public function testClassSlugifiers()
    {
        $this->assertTrue(function_exists('classpath_to_slug'), 'classpath_to_slug function should exist');
        $this->assertTrue(function_exists('slug_to_classpath'), 'slug_to_classpath function should exist');
    }

}