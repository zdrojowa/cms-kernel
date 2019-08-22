<?php

namespace Zdrojowa\InvestmentCMS\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;

/**
 * Class MenuRepository
 * @package Zdrojowa\InvestmentCMS\Facades
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
