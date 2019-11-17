<?php
/**
 * Contains the Modules Command class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-08-14
 */

namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Concord\Contracts\Concord;

class ModulesCommand extends Command
{
    /** @var string  */
    protected $signature = 'concord:modules {--a|all : List all modules, including implicit ones}';

    /** @var string  */
    protected $description = 'List Concord Modules';

    /** @var array  */
    protected $headers = ['#', 'Name', 'Kind', 'Version', 'Id', 'Namespace'];

    public function handle(Concord $concord)
    {
        $modules = $concord->getModules((bool) $this->option('all'));

        if ($modules->count()) {
            $this->showModules($modules);
        } else {
            $this->line('No modules have been registered. Add one in config/concord.php.');
        }
    }

    /**
     * Displays the list of modules on the output
     *
     * @param $modules Collection
     */
    protected function showModules(Collection $modules)
    {
        $table = [];
        $i     = 0;

        /** @var BaseModuleServiceProvider $module */
        foreach ($modules as $module) {
            $i++;

            $table[] = [
                'no'        => sprintf('%d.', $i),
                'name'      => $module->getManifest()->getName(),
                'kind'      => $module->getKind()->label(),
                'version'   => $module->getManifest()->getVersion(),
                'id'        => $module->getId(),
                'namespace' => $module->getNamespaceRoot()
            ];
        }

        $this->table($this->headers, $table);
    }
}
