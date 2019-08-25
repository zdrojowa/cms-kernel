<?php

use Zdrojowa\AuthModule\AuthModule;
use Zdrojowa\CmsKernel\Acl\AclRepository;
use Zdrojowa\CmsKernel\Booter\Booter;
use Zdrojowa\CmsKernel\Console\Commands\BooterShowErrorsCommand;
use Zdrojowa\CmsKernel\Console\Commands\CoreModulesBootedCommand;
use Zdrojowa\CmsKernel\Console\Commands\ListModuleCommand;
use Zdrojowa\CmsKernel\Core\Core;
use Zdrojowa\CmsKernel\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Variabler\Providers\ObjectNameProvider;
use Zdrojowa\CmsKernel\Variabler\Providers\ObjectPropertyProvider;
use Zdrojowa\CmsKernel\Variabler\Variabler;

return [
    // Section with declaration of cms options

    'enabled' => true,
    'debug' => true,

    'modules' => [
        AuthModule::class,
    ],

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
