<?php

namespace Zdrojowa\InvestmentCMS\Events\Module;

use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

/**
 * Class ModuleRegisterEvent
 * @package Zdrojowa\InvestmentCMS\Events\Module
 */
class ModuleRegisterEvent extends InvestmentCMSEvent
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
