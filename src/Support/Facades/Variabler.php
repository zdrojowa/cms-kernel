<?php

namespace Zdrojowa\CmsKernel\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * @package Zdrojowa\CmsKernel\Support\Facades
 *
 * @method static make($value, object $param)
 */
class Variabler extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CoreModules::VARIABLER;
    }
}
