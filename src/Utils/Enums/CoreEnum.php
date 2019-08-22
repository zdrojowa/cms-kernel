<?php

namespace Zdrojowa\CmsKernel\Utils\Enums;

/**
 * Class CoreEnum
 */
class CoreEnum
{

    public const CMS_CONFIG = 'cms-core';

    public const CMS_ENABLED_OPTION = 'cms-enabled';

    public const CORE_MODULES_SECTION = 'core-modules';
    public const MODULES_SECTION = 'modules';

    public const CMS_MIGRATIONS_USERS_TABLE_OPTION = 'cms-migrations-users-table';
    public const CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME = 'cms-migrations-users-table-column';
    public const CMS_MIGRATIONS_PERMISSIONS_TABLE_OPTION = 'cms-migrations-permissions-table';
    public const CMS_MIGRATIONS_PERMISSIONS_USERS_FOREIGN_KEY = 'cms-migrations-permissions-users-foreign-key';

    public const CORE_COMMANDS_SECTION = 'core-commands';

    public const CMS_SUPER_ADMIN_COLUMN_NAME = 'is_admin';
    public const CMS_SUPER_PERMISSION_ANCHOR = 'cms-super-permission-anchor';

    public const MODULES_CONFIG_DIR = 'modules';
}
