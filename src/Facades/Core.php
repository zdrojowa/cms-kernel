<?php

namespace Zdrojowa\CmsKernel\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class Core
 * @package Zdrojowa\CmsKernel\Facades
 *
 * @method static moduleManager(): ?ModuleManagerInterface
 * @method static aclRepository(): ?AclRepositoryInterface
 * @method static log($level, $message, array $context = null): CoreInterface
 * @method static getVersion(): string
 */
class Core extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return CoreModulesEnum::CORE;
    }
}
