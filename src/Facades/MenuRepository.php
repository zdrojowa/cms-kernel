<?php

namespace Zdrojowa\CmsKernel\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class MenuRepository
 * @package Zdrojowa\CmsKernel\Facades
 *
 * @method static addPresence(Module $module, Collection $presence): MenuRepository
 */
class MenuRepository extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CoreModulesEnum::MENU_REPOSITORY;
    }
}
