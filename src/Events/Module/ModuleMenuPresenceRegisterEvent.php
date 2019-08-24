<?php

namespace Zdrojowa\CmsKernel\Events\Module;

use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;
use Zdrojowa\CmsKernel\Menu\MenuPresence;

/**
 * Class ModuleMenuPresenceRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Module
 */
class ModuleMenuPresenceRegisterEvent extends CmsKernelEvent
{

    /**
     * @var ModuleInterface
     */
    public $module;
    /**
     * @var MenuPresence
     */
    public $menuPresence;

    /**
     * ModuleAclPresenceRegisterEvent constructor.
     *
     * @param ModuleInterface $module
     * @param MenuPresence $menuPresence
     */
    public function __construct(ModuleInterface $module, MenuPresence $menuPresence)
    {
        $this->module = $module;
        $this->menuPresence = $menuPresence;
    }
}
