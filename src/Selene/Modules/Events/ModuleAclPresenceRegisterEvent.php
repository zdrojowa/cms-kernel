<?php

namespace Selene\Modules\Events;

use Selene\Contracts\Acl\Presence\AclPresence;
use Selene\Contracts\Modules\Module;
use Selene\Events\CmsKernelEvent;

/**
 * Class ModuleAclPresenceRegisterEvent
 * @package Selene\Modules\Events
 */
class ModuleAclPresenceRegisterEvent extends CmsKernelEvent
{

    /**
     * @var Module
     */
    public $module;
    /**
     * @var AclPresence
     */
    public $aclPresence;

    /**
     * ModuleAclPresenceRegisterEvent constructor.
     *
     * @param Module $module
     * @param AclPresence $aclPresence
     */
    public function __construct(Module $module, AclPresence $aclPresence)
    {
        $this->module = $module;
        $this->aclPresence = $aclPresence;
    }
}
