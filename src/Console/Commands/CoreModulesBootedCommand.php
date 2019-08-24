<?php

namespace Zdrojowa\CmsKernel\Console\Commands;

use Illuminate\Console\Command;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;

/**
 * Class CoreModulesBootedCommand
 * @package Zdrojowa\CmsKernel\Console\Commands
 */
class CoreModulesBootedCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'booter:status';

    /**
     * @param BooterInterface $booter
     */
    public function handle(BooterInterface $booter)
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
