<?php

namespace Zdrojowa\CmsKernel\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * @method static make($value, object $param)
 */
class Variabler extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CoreModulesEnum::VARIABLER;
    }
}
