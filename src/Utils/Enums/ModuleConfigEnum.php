<?php


namespace Zdrojowa\CmsKernel\Utils\Enums;


use MyCLabs\Enum\Enum;

/**
 * Class ModuleConfigEnum
 * @package Zdrojowa\CmsKernel\Utils\Enums
 *
 * @method static MODULE_CONFIG_FILE()
 * @method static MODULE_ROUTES_FILE()
 * @method static MODULE_ROUTES_API_FILE()
 * @method static MODULE_PERMISSIONS_FILE()
 * @method static MODULE_EXTRA_FILE()
 * @method static MODULES_CONFIG_FOLDER()
 */
class ModuleConfigEnum extends Enum
{
    const MODULES_CONFIG_FOLDER = '../module-config/';
    const MODULE_CONFIG_FILE = 'module.yml';
    const MODULE_ROUTES_FILE = 'routes.yml';
    const MODULE_ROUTES_API_FILE = 'routes-api.yml';
    const MODULE_PERMISSIONS_FILE = 'permissions.yml';
    const MODULE_MENU_FILE = 'menu.yml';
    const MODULE_EXTRA_FILE = '__name__.yml';
}
