<?php

declare(strict_types=1);

/**
 * Contains the ManifestFileTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-13
 *
 */

namespace Konekt\Concord\Tests\Unit;

use Konekt\Concord\Module\ManifestFile;
use PHPUnit\Framework\TestCase;

class ManifestFileTest extends TestCase
{
    /** @test */
    public function it_can_not_be_instantiated_with_a_constructor()
    {
        $this->expectError();

        new ManifestFile('', '');
    }

    /** @test */
    public function it_can_be_instantiated_with_the_read_factory_method()
    {
        $manifest = ManifestFile::read($this->pathToDummyFile('manifest_with_name_and_version.php'));
        $this->assertInstanceOf(ManifestFile::class, $manifest);
    }

    /** @test */
    public function it_reads_the_name_and_the_version_from_the_manifest_file()
    {
        $manifest = ManifestFile::read($this->pathToDummyFile('manifest_with_name_and_version.php'));

        $this->assertEquals('Elmo Song Module', $manifest->getName());
        $this->assertEquals('7.9.0', $manifest->getVersion());
    }

    /** @test */
    public function it_returns_null_for_version_if_not_found_in_the_manifest_file()
    {
        $manifest = ManifestFile::read($this->pathToDummyFile('manifest_without_version.php'));

        $this->assertNull($manifest->getVersion());
    }

    /** @test */
    public function it_returns_npera_as_name_if_no_name_can_be_found_in_the_manifest_file()
    {
        $manifest = ManifestFile::read($this->pathToDummyFile('manifest_without_name.php'));

        $this->assertEquals('N/A', $manifest->getName());
    }

    private function pathToDummyFile(string $file): string
    {
        return dirname(__DIR__) . '/Dummies/' . $file;
    }
}
