<?php


namespace Zdrojowa\InvestmentCMS\Utils\Enums;


use MyCLabs\Enum\Enum;

/**
 * Class ModuleConfigEnum
 * @package Zdrojowa\InvestmentCMS\Utils\Enums
 *
 * @method static MODULE_CONFIG_FILE()
 * @method static MODULE_ROUTES_FILE()
 * @method static MODULE_ROUTES_API_FILE()
 * @method static MODULE_PERMISSIONS_FILE()
 */
class ModuleConfigEnum extends Enum
{
    const MODULE_CONFIG_FILE = 'module.yml';
    const MODULE_ROUTES_FILE = 'routes.yml';
    const MODULE_ROUTES_API_FILE = 'routes-api.yml';
    const MODULE_PERMISSIONS_FILE = 'permissions.yml';
}
