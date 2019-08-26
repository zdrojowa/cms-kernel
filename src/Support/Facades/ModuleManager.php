<?php

namespace Zdrojowa\CmsKernel\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * @package Zdrojowa\CmsKernel\Support\Facades
 *
 * @method static getModule(string $getShortName)
 */
class ModuleManager extends Facade
{

    protected static function getFacadeAccessor()
    {
        return CoreModules::MODULE_MANAGER;
    }
}
