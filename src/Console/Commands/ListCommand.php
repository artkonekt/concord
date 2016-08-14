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
use Konekt\Concord\Module;

class ListCommand extends Command
{
    /** @var string  */
    protected $signature = 'concord:list';

    /** @var string  */
    protected $description = 'List Concord Application Modules';

    /** @var array  */
    protected $headers = ['#', 'Name', 'Version'];

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
            $this->line('No modules have been registered so far. Go to config/concord.php to add one.');
        }
    }

    /**
     * Displays the list of modules on the output
     */
    public function showModules()
    {
        $table = [];
        $i     = 0;

        /** @var Module $module */
        foreach ($this->modules as $module) {
            $i++;

            $table[] = [
                'no'      => sprintf('%d.', $i),
                'name'    => $module->name,
                'version' => $module->version
            ];
        }

        $this->table($this->headers, $table);
    }


}