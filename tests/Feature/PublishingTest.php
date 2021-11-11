<?php

declare(strict_types=1);

/**
 * Contains the PublishingTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-06-20
 *
 */

namespace Konekt\Concord\Tests\Feature;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Konekt\Concord\Tests\Modules\SimpleBox\Providers\ModuleServiceProvider as SimpleBox;
use Konekt\Concord\Tests\Modules\SimpleBoxSubmodule1\Providers\ModuleServiceProvider as Submodule1;
use Konekt\Concord\Tests\Modules\SimpleBoxSubmodule2\Providers\ModuleServiceProvider as Submodule2;
use Konekt\Concord\Tests\TestCase;

class PublishingTest extends TestCase
{
    /** @test */
    public function a_box_publishes_a_group_called_own_migrations_only()
    {
        $this->assertContains(
            'own-migrations-only',
            ServiceProvider::publishableGroups()
        );
    }

    /** @test */
    public function a_box_publishes_its_very_own_migrations_under_the_own_migrations_only_group()
    {
        $this->assertCount(1, ServiceProvider::pathsToPublish(SimpleBox::class, 'own-migrations-only'));
    }

    /** @test */
    public function modules_only_publish_their_own_migrations()
    {
        $this->assertCount(1, ServiceProvider::pathsToPublish(Submodule1::class, 'migrations'));
        $this->assertCount(1, ServiceProvider::pathsToPublish(Submodule2::class, 'migrations'));
    }

    /** @test */
    public function a_box_publishes_the_migrations_from_all_its_submodules_under_migrations_group()
    {
        $publishedMigrations = $this->concord
            ->module('simple_box')
            ->pathsToPublish(SimpleBox::class, 'migrations');

        $this->assertCount(3, $publishedMigrations);
        $this->assertCount(1, collect($publishedMigrations)->filter(function ($value, $key) {
            return Str::endsWith($key, 'SimpleBox/resources/database/migrations');
        }));
        $this->assertCount(1, collect($publishedMigrations)->filter(function ($value, $key) {
            return Str::endsWith($key, 'SimpleBoxSubmodule1/resources/database/migrations');
        }));
        $this->assertCount(1, collect($publishedMigrations)->filter(function ($value, $key) {
            return Str::endsWith($key, 'SimpleBoxSubmodule2/resources/database/migrations');
        }));
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            SimpleBox::class => [
                'cascade_config' => [
                    'migrations' => false,
                    'some_key' => 'NO!',
                    'parent' => [
                        'child_1' => 'George'
                    ]
                ]
            ]
        ]);
    }
}
