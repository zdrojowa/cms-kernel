<?php

namespace Zdrojowa\InvestmentCMS\Utils\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class CoreModulesEnum
 * @package Zdrojowa\InvestmentCMS\Utils\Enums
 *
 * @method static CORE()
 * @method static BOOTER()
 * @method static MODULE_MANAGER()
 */
class CoreModulesEnum extends Enum
{
    public const CORE = 'cms-core';
    public const BOOTER = 'cms-booter';
    public const MODULE_MANAGER = 'cms-module-manager';
    public const ACL_REPOSITORY = 'cms-acl-repository';
    public const MIGRATION_REPOSITORY = 'cms-migration-repository';
    public const MIGRATOR = 'cms-migrator';
}
