<?php

namespace Zdrojowa\CmsKernel\Modules\Events;

use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleRegisterEvent
 * @package Zdrojowa\CmsKernel\Modules\Events
 */
class ModuleRegisterEvent extends CmsKernelEvent
{
    /**
     * @var Module
     */
    public $module;

    /**
     * ModuleRegisterEvent constructor.
     *
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }
}
