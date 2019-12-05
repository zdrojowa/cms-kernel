<?php

namespace Selene\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Selene\Acl\AclRepository;
use Selene\Booter\Booter;
use Selene\Core\Core;
use Selene\Modules\ModuleManager;
use Selene\Providers\AclRepositoryServiceProvider;
use Selene\Providers\CoreServiceProvider;
use Selene\Providers\ModuleManagerServiceProvider;
use Selene\Providers\VariablerServiceProvider;
use Selene\Support\Enums\Core\Core as CoreEnum;
use Selene\Support\Enums\Core\CoreModules;
use Selene\Variabler\Variabler;

class TestCase extends OrchestraTestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = $app['config'];

        $config->set(CoreEnum::CONFIG . '.' . CoreEnum::MODULES, []);
        $config->set(CoreEnum::CONFIG . '.' . CoreEnum::CORE_MODULES, [
            'core' => Core::class,
            'booter' => Booter::class,
            'module-manager' => ModuleManager::class,
            'acl-repository' => AclRepository::class,
            'variabler' => Variabler::class,
        ]);
        $config->set(CoreEnum::CONFIG . '.' . CoreEnum::DEBUG, true);
    }

    /**
     * Load package service provider
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CoreServiceProvider::class,
            VariablerServiceProvider::class,
            AclRepositoryServiceProvider::class,
            ModuleManagerServiceProvider::class,
        ];
    }

    protected function booter()
    {
        return $this->app->get(CoreModules::BOOTER);
    }

    protected function core()
    {
        return $this->app->get(CoreModules::CORE);
    }

    protected function variabler()
    {
        return $this->app->get(CoreModules::VARIABLER);
    }

    protected function moduleManager()
    {
        return $this->app->get(CoreModules::MODULE_MANAGER);
    }

    public function aclRepository()
    {
        return $this->app->get(CoreModules::ACL_REPOSITORY);
    }
}
