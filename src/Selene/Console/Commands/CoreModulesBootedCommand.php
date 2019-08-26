<?php

namespace Selene\Console\Commands;

use Illuminate\Console\Command;
use Selene\Contracts\Booter\Booter;

/**
 * Class CoreModulesBootedCommand
 * @package Selene\Console\Commands
 */
class CoreModulesBootedCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'booter:status';

    /**
     * @param Booter $booter
     */
    public function handle(Booter $booter)
    {
        $this->line('');
        $this->line('Booter status:');

        foreach ($booter->getCoreModulesStatus() as $module => $status) {
            if ($status) {
                $this->info("$module => booted");
            } else {
                $this->error("$module => can't boot");
            }
        }
        $this->line('');
    }
}
