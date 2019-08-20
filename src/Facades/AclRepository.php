<?php

namespace Zdrojowa\InvestmentCMS\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;

/**
 * Class AclRepository
 * @package Zdrojowa\InvestmentCMS\Facades
 *
 * @method static addPresence(Module $module, Collection $presence): AclRepository
 */
class AclRepository extends Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return CoreModulesEnum::ACL_REPOSITORY;
    }
}
