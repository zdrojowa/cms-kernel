<?php

namespace Selene\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Selene\Support\Enums\Core\CoreModules;

/**
 * @package Selene\Support\Facades
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
