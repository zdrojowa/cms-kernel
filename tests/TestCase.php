<?php

namespace Selene\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Selene\Providers\AclRepositoryServiceProvider;
use Selene\Providers\CoreServiceProvider;
use Selene\Providers\ModuleManagerServiceProvider;
use Selene\Providers\VariablerServiceProvider;
use Selene\Support\Enums\Core\Core;
use Selene\Support\Enums\Core\CoreModules;

class TestCase extends OrchestraTestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = $app['config'];

        $config->set(Core::CONFIG . '.' . Core::MODULES, []);
        $config->set(Core::CONFIG . '.' . Core::DEBUG, true);
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
