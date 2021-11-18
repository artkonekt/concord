<?php

declare(strict_types=1);

/**
 * Contains the BaseModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */

namespace Konekt\Concord;

use Illuminate\Support\ServiceProvider;
use Konekt\Concord\Concerns\AutoGeneratesModuleId;
use Konekt\Concord\Concerns\HasDefaultConvention;
use Konekt\Concord\Concerns\HasModuleConfig;
use Konekt\Concord\Concerns\ReadsManifestFile;
use Konekt\Concord\Concerns\RegistersEnums;
use Konekt\Concord\Contracts\Concord as ConcordContract;
use Konekt\Concord\Contracts\Module;
use Konekt\Concord\Module\Kind;
use ReflectionClass;

class BaseModuleServiceProvider extends ServiceProvider implements Module
{
    use HasModuleConfig;
    use AutoGeneratesModuleId;
    use HasDefaultConvention;
    use RegistersEnums;
    use ReadsManifestFile;

    private string $basePath;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->concord = $app->make(ConcordContract::class);
        $this->basePath = dirname(dirname((new ReflectionClass(static::class))->getFileName()));
    }

    public function boot()
    {
        if ($this->areMigrationsEnabled()) {
            //$this->registerMigrations();
        }

        if ($this->areModelsEnabled()) {
            //$this->registerModels();
            $this->registerEnums();
            //$this->registerRequestTypes();
        }
    }

    public function getName(): string
    {
        return $this->manifest(static::getConvention())->getName();
    }

    public function getVersion(): ?string
    {
        return $this->manifest(static::getConvention())->getVersion();
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getNamespaceRoot(): string
    {
        return '';
    }

    public function getKind(): Kind
    {
        return Kind::MODULE();
    }

    public function shortName()
    {
        return '';
    }
}
