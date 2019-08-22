<?php

namespace Zdrojowa\CmsKernel\Events\Module;

use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleManagerInitializeEvent
 * @package Zdrojowa\CmsKernel\Events\Module
 */
class ModuleManagerInitializeEvent extends CmsKernelEvent
{

    /**
     * @var ModuleManagerInterface
     */
    public $moduleManager;

    /**
     * ModuleManagerInitializeEvent constructor.
     *
     * @param ModuleManagerInterface $moduleManager
     */
    public function __construct(ModuleManagerInterface $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }
}
