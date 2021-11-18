<?php

declare(strict_types=1);

/**
 * Contains the ReadsManifestFile trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-18
 *
 */

namespace Konekt\Concord\Concerns;

use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Module\ManifestFile;

trait ReadsManifestFile
{
    private ?ManifestFile $manifestFile = null;

    protected function manifest(Convention $convention): ManifestFile
    {
        if (null === $this->manifestFile) {
            $this->manifestFile = ManifestFile::read($this->getBasePath() . '/' . $convention->manifestFile());
        }

        return $this->manifestFile;
    }
}
