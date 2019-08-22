<?php

namespace Zdrojowa\InvestmentCMS\Events\Module;

use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;
use Zdrojowa\InvestmentCMS\Menu\MenuPresence;

/**
 * Class ModuleMenuPresenceRegisterEvent
 * @package Zdrojowa\InvestmentCMS\Events\Module
 */
class ModuleMenuPresenceRegisterEvent extends InvestmentCMSEvent
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
