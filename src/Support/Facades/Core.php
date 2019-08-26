<?php

namespace Zdrojowa\CmsKernel\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class Core
 * @package Zdrojowa\CmsKernel\Support\Facades
 *
 * @method static moduleManager(): ?ModuleManager
 * @method static aclRepository(): ?AclRepository
 * @method static log($level, $message, array $context = null): Core
 * @method static getVersion(): string
 */
class Core extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return CoreModules::CORE;
    }
}
