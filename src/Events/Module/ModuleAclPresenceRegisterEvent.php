<?php


namespace Zdrojowa\InvestmentCMS\Events\Module;


use Zdrojowa\InvestmentCMS\Contracts\Acl\AclPresence;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

/**
 * Class ModuleAclPresenceRegisterEvent
 * @package Zdrojowa\InvestmentCMS\Events\Module
 */
class ModuleAclPresenceRegisterEvent extends InvestmentCMSEvent
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
     * @param Module $module
     * @param AclPresence $aclPresence
     */
    public function __construct(Module $module, AclPresence $aclPresence)
    {
        $this->module = $module;
        $this->aclPresence = $aclPresence;
    }
}
