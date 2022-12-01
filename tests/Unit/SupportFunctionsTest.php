<?php

declare(strict_types=1);

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

use Illuminate\Database\Eloquent\Relations\Relation;
use Konekt\Concord\Tests\Dummies\Funky;
use Konekt\Concord\Tests\Dummies\Swing;
use Konekt\Concord\Tests\Dummies\TripHop;
use PHPUnit\Framework\TestCase as PHPUnitBaseTestCase;

class SupportFunctionsTest extends PHPUnitBaseTestCase
{
    /** @test */
    public function helper_functions_exist()
    {
        $this->assertTrue(function_exists('classpath_to_slug'), 'classpath_to_slug function should exist');
        $this->assertTrue(function_exists('slug_to_classpath'), 'slug_to_classpath function should exist');
    }

    /**
     * @test
     * @dataProvider slugProvider
     */
    public function slug_to_classpath_properly_converts_back_to_fqcn($classPath, $slug)
    {
        $this->assertEquals($classPath, slug_to_classpath($slug));
    }

    /**
     * @test
     * @dataProvider classpathProvider
     */
    public function classpath_to_slug_converts_fqcn_to_snake_case_with_backslashes_to_dots($classPath, $slug)
    {
        $this->assertEquals($slug, classpath_to_slug($classPath));
    }

    /**
     * @test
     * @dataProvider moduleIdProvider
     */
    public function concord_module_is_being_properly_obtained($class, $id)
    {
        $this->assertEquals($id, concord_module_id($class, new ConcordDefault()));
    }

    /** @test */
    public function the_morph_type_of_function_returns_the_relation_alias_if_set_or_the_classname_if_no_relation_morphmap_entry_was_found()
    {
        Relation::morphMap([
            'funky'    => Funky::class,
            'trip_hop' => TripHop::class,
        ]);

        $this->assertEquals('funky', morph_type_of(Funky::class));
        $this->assertEquals('trip_hop', morph_type_of(new TripHop()));
        $this->assertEquals(Swing::class, morph_type_of(Swing::class));
        $this->assertEquals(Swing::class, morph_type_of(new Swing()));
    }

    public function classpathProvider()
    {
        return [
            ['\App\Services\BamBamService', 'app.services.bam_bam_service'],
            ['App\Services\BamBamService', 'app.services.bam_bam_service'],
            ['BamBamService', 'bam_bam_service'],
            ['\BamBamService', 'bam_bam_service'],
            ['App\SerViCes\BamBamService', 'app.ser_vi_ces.bam_bam_service'],
            ['App\SerViCes\BamBamService\\', 'app.ser_vi_ces.bam_bam_service'],
            ['Vendor\WTF\Models\Blah\\', 'vendor.w_t_f.models.blah'],
        ];
    }

    public function slugProvider()
    {
        return [
            ['App\Services\BamBamService', 'app.services.bam_bam_service'],
            ['App\SerViCes\BamBamService', 'app.ser_vi_ces.bam_bam_service'],
            ['BamBamService', 'bam_bam_service'],
            ['Vendor\WTF\Models\Blah', 'vendor.w_t_f.models.blah'],
        ];
    }
}
