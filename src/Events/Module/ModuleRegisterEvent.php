<?php

namespace Zdrojowa\CmsKernel\Events\Module;

use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Module
 */
class ModuleRegisterEvent extends CmsKernelEvent
{
    /**
     * @var ModuleInterface
     */
    public $module;

    /**
     * ModuleRegisterEvent constructor.
     *
     * @param ModuleInterface $module
     */
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }
}
