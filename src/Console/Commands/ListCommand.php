<?php
/**
 * Contains the ListCommand.php class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 *
 */


namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Konekt\Concord\Concord;
use Konekt\Concord\AbstractModuleServiceProvider;

class ListCommand extends Command
{
    /** @var string  */
    protected $signature = 'concord:list';

    /** @var string  */
    protected $description = 'List Concord Application Modules';

    /** @var array  */
    protected $headers = ['#', 'Name', 'Version', 'Namespace'];

    /** @var  Collection */
    protected $modules;


    public function __construct(Concord $concord)
    {
        parent::__construct();

        $this->modules = $concord->getModules();
    }

    /**
     * Execute the command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->modules->count()) {
            $this->showModules();
        } else {
            $this->line('No modules have been registered. Add one in config/concord.php.');
        }
    }

    /**
     * Displays the list of modules on the output
     */
    public function showModules()
    {
        $table = [];
        $i     = 0;

        /** @var AbstractModuleServiceProvider $module */
        foreach ($this->modules as $module) {
            $i++;

            $table[] = [
                'no'        => sprintf('%d.', $i),
                'name'      => $module->getManifest()->getName(),
                'version'   => $module->getManifest()->getVersion(),
                'namespace' => $module->getNamespaceRoot()
            ];
        }

        $this->table($this->headers, $table);
    }


}