<?php

namespace Selene\Support\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Selene\Contracts\Modules\Module;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class MenuRepository
 * @package Selene\Support\Facades
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
