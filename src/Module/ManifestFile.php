<?php

declare(strict_types=1);

/**
 * Contains the Module ManifestFile class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */

namespace Konekt\Concord\Module;

use RuntimeException;

final class ManifestFile
{
    private string $name;

    private ?string $version;

    public static function read(string $filePath): ManifestFile
    {
        if (!is_readable($filePath)) {
            throw new RuntimeException("The module manifest file `$filePath` can not be read");
        }

        $data = include($filePath);

        return new ManifestFile($data['name'] ?? 'N/A', $data['version'] ?? null);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    private function __construct(string $name, ?string $version)
    {
        $this->name = $name;
        $this->version = $version;
    }
}
