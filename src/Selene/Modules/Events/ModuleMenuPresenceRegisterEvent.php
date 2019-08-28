<?php

namespace Selene\Modules\Events;

use Selene\Contracts\Modules\Module;
use Selene\Events\CmsKernelEvent;
use Selene\Menu\MenuPresence;

/**
 * Class ModuleMenuPresenceRegisterEvent
 * @package Selene\Modules\Events
 */
class ModuleMenuPresenceRegisterEvent extends CmsKernelEvent
{

    /**
     * @var Module
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
