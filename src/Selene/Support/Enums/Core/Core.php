<?php

namespace Selene\Support\Enums\Core;

/**
 * @method static moduleManager()
 */
class Core
{
    public const CONFIG = 'selene';

    public const ENABLED = 'enabled';
    public const DEBUG = 'debug';

    public const CORE_MODULES = 'core-modules';
    public const MODULES = 'modules';

    public const USERS_TABLE = 'users-table';
    public const USERS_TABLE_COLUMN = 'users-table-column';

    public const PERMISSIONS_TABLE = 'permissions-table';
    public const PERMISSIONS_FOREIGN_KEY = 'permissions-foreign-key';

    public const COMMANDS = 'commands';
    public const OBLIGATORY_COMMANDS = 'commands-obligatory';

    public const ADMIN_COLUMN = 'admin-column';
    public const ADMIN_ANCHOR = 'admin-anchor';

    public const VARIABLER_PROVIDERS = 'variabler-providers';

    public const MENU_ORDER = 'menu-order';
}
