<?php

namespace Selene\Console\Commands;

use Illuminate\Console\Command;
use Selene\Contracts\Booter\Booter;

/**
 * Class BooterShowErrorsCommand
 * @package Selene\Console\Commands
 */
class BooterShowErrorsCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'booter:errors';

    /**
     * @param Booter $booter
     */
    public function handle(Booter $booter)
    {
        foreach ($booter->getErrors() as $error) {
            $this->error($error);
        }
    }
}
