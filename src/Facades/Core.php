<?php

namespace Zdrojowa\InvestmentCMS\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;

/**
 * Class Core
 * @package Zdrojowa\InvestmentCMS\Facades
 *
 * @method static setModuleManager(ModuleManagerInterface $moduleManager)
 * @method static loadModuleManagerModules()
 * @method static getModuleManager(): ModuleManagerInterface
 * @method static getModulesManager()
 * @method static hasModuleManager()
 */
class Core extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return CoreModulesEnum::CORE;
    }
}
