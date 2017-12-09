<?php
/**
 * Contains the Models Command class
 *
 * @copyright   Copyright (c) Lajos Fazakas
 * @author      Lajos Fazakas
 * @license     MIT
 * @since       2017-04-06
 */

namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Konekt\Concord\Contracts\Concord;

class ModelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'concord:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Models';

    /** @var array */
    protected $headers = ['Entity', 'Contract', 'Model'];

    /**
     * Execute the console command.
     *
     * @param Concord $concord
     *
     * @return mixed
     */
    public function handle(Concord $concord)
    {
        $bindings = $concord->getModelBindings();

        if ($bindings->count()) {
            $this->showBindings($bindings);
        } else {
            $this->line('No model bindings have been registered.');
        }
    }

    /**
     * Displays the list of model bindings on the output
     *
     * @param Collection $bindings
     */
    protected function showBindings(Collection $bindings)
    {
        $table = [];

        $bindings->map(function ($item, $key) {
            return [
                'shortName' => substr(strrchr($key, '\\'), 1),
                'abstract'  => $key,
                'concrete'  => $item
            ];
        })->sort(function ($a, $b) {
            return $a['shortName'] > $b['shortName'];
        })->each(function ($binding) use (&$table) {
            $table[] = [
                $binding['shortName'],
                $binding['abstract'],
                $binding['concrete'],
            ];
        });

        $this->table($this->headers, $table);
    }
}
