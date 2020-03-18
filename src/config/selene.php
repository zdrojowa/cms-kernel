<?php

use Selene\Acl\AclRepository;
use Selene\Booter\Booter;
use Selene\Console\Commands\BooterShowErrorsCommand;
use Selene\Console\Commands\CoreModulesBootedCommand;
use Selene\Console\Commands\ListModuleCommand;
use Selene\Core\Core;
use Selene\Modules\ModuleManager;
use Selene\Variabler\Providers\ObjectNameProvider;
use Selene\Variabler\Providers\ObjectPropertyProvider;
use Selene\Variabler\Variabler;

return [
    // Section with declaration of cms options

    'enabled' => true,
    'debug'   => true,
    'is_dev'  => false,

    'modules' => [
    ],

    'menu-order' => [

    ],

    'migrations' => true,

    'core-modules' => [
        'core' => Core::class,
        'booter' => Booter::class,
        'module-manager' => ModuleManager::class,
        'acl-repository' => AclRepository::class,
        'variabler' => Variabler::class,
    ],

    'users-table' => 'users',
    'users-table-column' => 'permission_package_id',
    'permissions-foreign-key' => 'users_permission_package_id_foreign',

    'permissions-table' => 'permission_packages',

    'commands' => [
        ListModuleCommand::class,
    ],

    'commands-obligatory' => [
        CoreModulesBootedCommand::class,
        BooterShowErrorsCommand::class
    ],

    'admin-column' => 'admin',

    'admin-anchor' => '*',

    'variabler-providers' => [
        'name' => ObjectNameProvider::class,
        'property' => ObjectPropertyProvider::class
    ],

];
