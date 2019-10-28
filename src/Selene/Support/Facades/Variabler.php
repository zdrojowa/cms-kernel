<?php

namespace Selene\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Selene\Support\Enums\Core\CoreModules;

/**
 * @package Selene\Support\Facades
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
