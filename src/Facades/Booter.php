<?php

namespace Zdrojowa\InvestmentCMS\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;

/**
 * Class Booter
 * @package Zdrojowa\InvestmentCMS\Facades
 *
 * @method static markCmsEnabled()
 * @method static canCmsBoot()
 */
class Booter extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return CoreModulesEnum::BOOTER;
    }
}
