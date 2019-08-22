<?php

namespace Zdrojowa\CmsKernel\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class Booter
 * @package Zdrojowa\CmsKernel\Facades
 *
 * @method static markCmsEnabled()
 * @method static canCmsBoot()
 * @method static isCmsEnabled()
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
