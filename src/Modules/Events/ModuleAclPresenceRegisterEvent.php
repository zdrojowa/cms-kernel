<?php

namespace Zdrojowa\CmsKernel\Modules\Events;

use Zdrojowa\CmsKernel\Contracts\Acl\Presence\AclPresence;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleAclPresenceRegisterEvent
 * @package Zdrojowa\CmsKernel\Modules\Events
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
