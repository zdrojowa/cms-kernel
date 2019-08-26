<?php

namespace Zdrojowa\CmsKernel\Support\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class MenuRepository
 * @package Zdrojowa\CmsKernel\Support\Facades
 *
 * @method static addPresence(Module $module, Collection $presence): MenuRepository
 * @method static getPresence(): Collection
 */
class MenuRepository extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CoreModules::MENU_REPOSITORY;
    }
}
