<?php
/**
 * Contains the MakeModule Command class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-01-18
 *
 */


namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\GeneratorCommand;


class MakeModuleCommand extends GeneratorCommand
{
    /** @var string  */
    protected $name = 'make:module';

    /** @var string  */
    protected $description = 'Create a new Concord module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }

        $name = $this->getNameInput();
        $manifestPath = str_replace('Providers/ModuleServiceProvider', 'resources/mainfest', $this->getPath($this->parseName($name)));

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
        return $rootNamespace . '\\Modules';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name) . '/Providers/ModuleServiceProvider.php';
    }

    protected function buildManifest($name)
    {
        $stub = $this->files->get(__DIR__ . '/stubs/module_manifest.stub');

        return str_replace('DummyName', $name, $stub);
    }

}