<?php

namespace Zdrojowa\CmsKernel\Events\Module;

use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Module
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
