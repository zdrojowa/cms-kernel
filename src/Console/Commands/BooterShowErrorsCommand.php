<?php

namespace Zdrojowa\CmsKernel\Console\Commands;

use Illuminate\Console\Command;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;

/**
 * Class BooterShowErrorsCommand
 * @package Zdrojowa\CmsKernel\Console\Commands
 */
class BooterShowErrorsCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'booter:errors';

    /**
     * @param BooterInterface $booter
     */
    public function handle(BooterInterface $booter)
    {
        foreach ($booter->getErrors() as $error) {
            $this->error($error);
        }
    }
}
