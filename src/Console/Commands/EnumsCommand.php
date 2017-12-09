<?php
/**
 * Contains the Enums Command class
 *
 * @copyright   Copyright (c) Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-09
 */

namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Konekt\Concord\Contracts\Concord;

class EnumsCommand extends Command
{
    protected $signature = 'concord:enums';

    protected $description = 'List Enums';

    protected $headers = ['Shorthand', 'Contract', 'Concrete'];

    public function handle(Concord $concord)
    {
        $bindings = $concord->getEnumBindings();

        if ($bindings->count()) {
            $this->showBindings($bindings);
        } else {
            $this->line('No enums have been registered.');
        }
    }

    /**
     * Displays the list of enum bindings on the output
     *
     * @param Collection $bindings
     */
    protected function showBindings(Collection $bindings)
    {
        $table = [];

        $bindings->map(function ($item, $key) {
            return [
                'shortName' => shorten($key),
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
