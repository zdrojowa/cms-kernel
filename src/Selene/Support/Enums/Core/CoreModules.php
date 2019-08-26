<?php

namespace Selene\Support\Enums\Core;

use MyCLabs\Enum\Enum;

/**
 * @method static BOOTER()
 * @method static MENU_REPOSITORY()
 * @method static CORE()
 * @method static MODULE_MANAGER()
 * @method static VARIABLER()
 * @method static ACL_REPOSITORY()
 */
class CoreModules extends Enum
{
    public const CORE = 'core';
    public const BOOTER = 'booter';
    public const MODULE_MANAGER = 'module-manager';
    public const ACL_REPOSITORY = 'acl-repository';
    public const MENU_REPOSITORY = 'menu-repository';
    public const VARIABLER = 'variabler';
}
