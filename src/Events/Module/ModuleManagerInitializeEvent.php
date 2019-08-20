<?php

namespace Zdrojowa\InvestmentCMS\Events\Module;

use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

/**
 * Class ModuleManagerInitializeEvent
 * @package Zdrojowa\InvestmentCMS\Events\Module
 */
class ModuleManagerInitializeEvent extends InvestmentCMSEvent
{

    /**
     * @var ModuleManagerInterface
     */
    public $moduleManager;

    /**
     * ModuleManagerInitializeEvent constructor.
     *
     * @param ModuleManagerInterface $moduleManager
     */
    public function __construct(ModuleManagerInterface $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }
}
