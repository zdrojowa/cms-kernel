<?php

namespace Zdrojowa\CmsKernel\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class AclRepository
 * @package Zdrojowa\CmsKernel\Facades
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
