<?php
/**
 * Contains the MakeModule Command class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-01-18
 */

namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Konekt\Concord\Contracts\Concord;
use Konekt\Concord\Contracts\Convention;
use Konekt\Concord\Exceptions\UnknownLaravelVersionException;

class MakeModuleCommand extends GeneratorCommand
{
    /** @var string  */
    protected $name = 'make:module';

    /** @var string  */
    protected $description = 'Create a new Concord module';

    /** @var Convention */
    protected $convention;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    public function __construct(Filesystem $files, Concord $concord)
    {
        parent::__construct($files);

        $this->convention = $concord->getConvention();
    }

    public function handle()
    {
        if (false === parent::handle()) {
            return;
        }

        $providerFileName = $this->getPath($this->qualifyClass($this->getNameInput()));
        $this->files->put(//Replace the
            $providerFileName,
            str_replace(
                'DummyProviderFolder',
                str_replace('/', '\\', $this->convention->providersFolder()),
                $this->files->get($providerFileName)
            )
        );

        $name         = $this->getNameInput();
        $manifestPath = str_replace(
            sprintf('%s/ModuleServiceProvider.php', $this->convention->providersFolder()),
            $this->convention->manifestFile(),
            $this->getPath($this->getFQCNComp($name))
        );

        if (!$this->files->exists($manifestPath)) {
            $this->makeDirectory($manifestPath);
            $this->files->put($manifestPath, $this->buildManifest($name));
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/module_provider.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . str_replace('/', '\\', $this->convention->modulesFolder());
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->laravel->getNamespace(), '', $name);

        return sprintf(
            '%s/%s/%s/%s',
            $this->laravel['path'],
            str_replace('\\', '/', $name),
            $this->convention->providersFolder(),
            'ModuleServiceProvider.php'
        );
    }

    protected function buildManifest($name)
    {
        $stub = $this->files->get(__DIR__ . '/stubs/module_manifest.stub');

        return str_replace('DummyName', $name, $stub);
    }

    /**
     * Returns the fully qualified class name from the base generator command in a Laravel 5.3/5.4
     * compatible manner
     *
     * @param string    $name
     *
     * @throws UnknownLaravelVersionException
     *
     * @return string
     */
    protected function getFQCNComp($name)
    {
        if (method_exists($this, 'qualifyClass')) {
            return $this->qualifyClass($name);
        } elseif (method_exists($this, 'parseName')) {
            return $this->parseName($name);
        }
        throw new UnknownLaravelVersionException(
            sprintf(
                "There's an incompatible parent class `%s` in your installed version of Laravel",
                get_parent_class($this)
            )
        );
    }
}
