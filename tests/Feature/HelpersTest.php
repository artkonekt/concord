<?php

declare(strict_types=1);

/**
 * Contains the HelpersTest class
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-13
 *
 */

namespace Konekt\Concord\Tests\Feature;

use Konekt\Concord\Contracts\Concord;
use Konekt\Concord\Tests\Feature\Helpers\HelloHelper;
use Konekt\Concord\Tests\Feature\Helpers\KeyValueStoreHelper;
use Konekt\Concord\Tests\TestCase;

class HelpersTest extends TestCase
{
    public function testFunctionsExist()
    {
        $this->assertTrue(function_exists('concord'), 'concord function should exist');
        $this->assertTrue(function_exists('helper'), 'helper function should exist');
    }

    public function testConcordFunctionReturnsCompatibleInstance()
    {
        $this->assertInstanceOf(Concord::class, concord());
    }

    public function testHelperRegistrationWorks()
    {
        $this->app->concord->registerHelper('hello', HelloHelper::class);

        $this->assertInstanceOf(HelloHelper::class, helper('hello'));
        $this->assertEquals('hello', helper('hello')->hello());
    }

    public function testHelpersAreSingletons()
    {
        $this->app->concord->registerHelper('registry', KeyValueStoreHelper::class);

        helper('registry')->set('foo', 'bar');
        $this->assertEquals('bar', helper('registry')->get('foo'));
    }

    public function testHelpersFunctionAndConcordMethodAreSameSource()
    {
        $this->app->concord->registerHelper('registry', KeyValueStoreHelper::class);

        helper('registry')->set('ach ja', 'nisch-nisch');
        $this->assertEquals('nisch-nisch', $this->app->concord->helper('registry')->get('ach ja'));
    }
}
