<?php

namespace Zdrojowa\CmsKernel\Utils\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class CoreModulesEnum
 * @package Zdrojowa\CmsKernel\Utils\Enums
 *
 * @method static CORE()
 * @method static BOOTER()
 * @method static MODULE_MANAGER()
 * @method static ACL_REPOSITORY()
 * @method static MENU_REPOSITORY()
 */
class CoreModulesEnum extends Enum
{
    public const CORE = 'cms-core';
    public const BOOTER = 'cms-booter';
    public const MODULE_MANAGER = 'cms-module-manager';
    public const ACL_REPOSITORY = 'cms-acl-repository';
    public const MENU_REPOSITORY = 'cms-menu-repository';
    public const VARIABLER = 'cms-variabler';
}
