<?php

namespace Zdrojowa\CmsKernel\Modules\Events;

use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleManagerInitializeEvent
 * @package Zdrojowa\CmsKernel\Modules\Events
 */
class ModuleManagerInitializeEvent extends CmsKernelEvent
{

    /**
     * @var ModuleManager
     */
    public $moduleManager;

    /**
     * ModuleManagerInitializeEvent constructor.
     *
     * @param ModuleManager $moduleManager
     */
    public function __construct(ModuleManager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }
}
