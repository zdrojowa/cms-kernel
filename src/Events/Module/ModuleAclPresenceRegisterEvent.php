<?php


namespace Zdrojowa\CmsKernel\Events\Module;


use Zdrojowa\CmsKernel\Contracts\Acl\AclPresence;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class ModuleAclPresenceRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Module
 */
class ModuleAclPresenceRegisterEvent extends CmsKernelEvent
{

    /**
     * @var ModuleInterface
     */
    public $module;
    /**
     * @var AclPresence
     */
    public $aclPresence;

    /**
     * ModuleAclPresenceRegisterEvent constructor.
     *
     * @param ModuleInterface $module
     * @param AclPresence $aclPresence
     */
    public function __construct(ModuleInterface $module, AclPresence $aclPresence)
    {
        $this->module = $module;
        $this->aclPresence = $aclPresence;
    }
}
