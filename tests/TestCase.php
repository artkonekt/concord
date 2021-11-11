<?php

declare(strict_types=1);
/**
 * Contains the base TestCase class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-12
 *
 */

namespace Konekt\Concord\Tests;

use Konekt\Concord\ConcordServiceProvider;
use Konekt\Concord\Contracts\Concord;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /** @var  Concord   This was added only to help IDE auto-completion */
    protected $concord;

    protected function setUp(): void
    {
        parent::setUp();

        $this->concord = $this->app->make('concord');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConcordServiceProvider::class
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
