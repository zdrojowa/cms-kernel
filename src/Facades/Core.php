<?php

namespace Zdrojowa\CmsKernel\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class Core
 * @package Zdrojowa\CmsKernel\Facades
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
