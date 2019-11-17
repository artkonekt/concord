<?php
/**
 * Contains the VersionCommand class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-14
 *
 */

namespace Konekt\Concord\Console\Commands;

use Illuminate\Console\Command;
use Konekt\Concord\Contracts\Concord;

class VersionCommand extends Command
{
    /** @var string  */
    protected $name = 'concord:version';

    /** @var string  */
    protected $description = 'Displays Concord version';

    public function handle(Concord $concord)
    {
        $this->info($concord->getVersion());
    }
}
