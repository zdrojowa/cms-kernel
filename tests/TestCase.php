<?php

namespace Zdrojowa\CmsKernel\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use \Zdrojowa\CmsKernel\Providers\AclRepositoryServiceProvider;
use \Zdrojowa\CmsKernel\Providers\CoreServiceProvider;
use \Zdrojowa\CmsKernel\Providers\ModuleManagerServiceProvider;
use \Zdrojowa\CmsKernel\Providers\VariablerServiceProvider;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

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
