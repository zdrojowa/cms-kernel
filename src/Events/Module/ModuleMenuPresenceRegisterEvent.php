<?php

namespace Zdrojowa\CmsKernel\Events\Module;

use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;
use Zdrojowa\CmsKernel\Menu\MenuPresence;

/**
 * Class ModuleMenuPresenceRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Module
 */
class ModuleMenuPresenceRegisterEvent extends CmsKernelEvent
{
    /**
     * @var Module
     *
     */
    public $module;
    /**
     * @var MenuPresence
     */
    public $menuPresence;

    /**
     * ModuleAclPresenceRegisterEvent constructor.
     *
     * @param Module $module
     * @param MenuPresence $menuPresence
     */
    public function __construct(Module $module, MenuPresence $menuPresence)
    {
        $this->module = $module;
        $this->menuPresence = $menuPresence;
    }
}
