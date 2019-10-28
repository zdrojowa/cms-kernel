<?php

namespace Selene\Modules\Events;

use Selene\Contracts\Modules\ModuleManager;
use Selene\Events\CmsKernelEvent;

/**
 * Class ModuleManagerInitializeEvent
 * @package Selene\Modules\Events
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
