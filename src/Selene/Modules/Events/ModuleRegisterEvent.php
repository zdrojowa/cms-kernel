<?php

namespace Selene\Modules\Events;

use Selene\Contracts\Modules\Module;
use Selene\Events\CmsKernelEvent;

/**
 * Class ModuleRegisterEvent
 * @package Selene\Modules\Events
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
