<?php

namespace Zdrojowa\CmsKernel\Support\Enums\Modules;

use MyCLabs\Enum\Enum;

/**
 * @method static PERMISSIONS_FILE()
 * @method static ROUTES_API_FILE()
 * @method static ROUTES_FILE()
 * @method static MENU_FILE()
 * @method static CONFIG_FILE()
 * @method static EXTRA_FILE()
 * @method static MODULE_EXTRA_FILE()
 */
class ModuleConfig extends Enum
{
    const CONFIG_FOLDER = '../module-config/';
    const CONFIG_FILE = 'module.yml';

    const ROUTES_FILE = 'routes.yml';
    const ROUTES_API_FILE = 'routes-api.yml';

    const PERMISSIONS_FILE = 'permissions.yml';

    const MENU_FILE = 'menu.yml';
    const EXTRA_FILE = '__name__.yml';
}
