<?php

use Zdrojowa\AuthModule\AuthModule;
use Zdrojowa\CmsKernel\Acl\AclRepository;
use Zdrojowa\CmsKernel\Console\Commands\CoreModulesBootedCommand;
use Zdrojowa\CmsKernel\Console\Commands\ListModuleCommand;
use Zdrojowa\CmsKernel\Core\Booter;
use Zdrojowa\CmsKernel\Core\Core;
use Zdrojowa\CmsKernel\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;
use Zdrojowa\CmsKernel\Utils\Variabler\Providers\ObjectNameProvider;
use Zdrojowa\CmsKernel\Utils\Variabler\Providers\ObjectPropertyProvider;
use Zdrojowa\CmsKernel\Variabler\Variabler;

return [
    // Section with declaration of cms options

    CoreEnum::CMS_ENABLED_OPTION => true,

    // Section with declaration of reusable modules

    CoreEnum::MODULES_SECTION => [
        AuthModule::class
    ],

    // Section with declaration of core modules

    CoreEnum::CORE_MODULES_SECTION => [
        CoreModulesEnum::CORE => Core::class,
        CoreModulesEnum::BOOTER => Booter::class,
        CoreModulesEnum::MODULE_MANAGER => ModuleManager::class,
        CoreModulesEnum::ACL_REPOSITORY => AclRepository::class,
        CoreModulesEnum::VARIABLER => Variabler::class
    ],

    CoreEnum::CMS_MIGRATIONS_USERS_TABLE_OPTION => 'users',
    CoreEnum::CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME => 'permission_package_id',
    CoreEnum::CMS_MIGRATIONS_PERMISSIONS_USERS_FOREIGN_KEY => 'users_permission_package_id_foreign',

    CoreEnum::CMS_MIGRATIONS_PERMISSIONS_TABLE_OPTION => 'permission_packages',

    CoreEnum::CORE_COMMANDS_SECTION => [
        ListModuleCommand::class,
    ],

    CoreEnum::CORE_OBLIGATORY_COMMANDS_SECTION => [
        CoreModulesBootedCommand::class
    ],

    CoreEnum::CMS_SUPER_ADMIN_COLUMN_NAME => 'admin',

    CoreEnum::CMS_SUPER_PERMISSION_ANCHOR => '*',

    CoreEnum::VARIABLER_PROVIDERS_SECTION => [
        'name' => ObjectNameProvider::class,
        'property' => ObjectPropertyProvider::class
    ]

];
