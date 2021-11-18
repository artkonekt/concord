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
