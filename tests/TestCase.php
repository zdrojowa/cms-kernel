<?php

namespace Zdrojowa\CmsKernel\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use \Zdrojowa\CmsKernel\Providers\AclRepositoryServiceProvider;
use \Zdrojowa\CmsKernel\Providers\CoreServiceProvider;
use \Zdrojowa\CmsKernel\Providers\ModuleManagerServiceProvider;
use \Zdrojowa\CmsKernel\Providers\VariablerSerivceProvider;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

class TestCase extends OrchestraTestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = $app['config'];

        $config->set(CoreEnum::CMS_CONFIG . '.' . CoreEnum::MODULES_SECTION, []);
        $config->set(CoreEnum::CMS_CONFIG . '.' . CoreEnum::CMS_DEBUG, true);
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
            VariablerSerivceProvider::class,
            AclRepositoryServiceProvider::class,
            ModuleManagerServiceProvider::class,
        ];
    }

    protected function booter()
    {
        return $this->app->get(CoreModulesEnum::BOOTER);
    }

    protected function core()
    {
        return $this->app->get(CoreModulesEnum::CORE);
    }

    protected function variabler()
    {
        return $this->app->get(CoreModulesEnum::VARIABLER);
    }

    protected function moduleManager()
    {
        return $this->app->get(CoreModulesEnum::MODULE_MANAGER);
    }

    public function aclRepository()
    {
        return $this->app->get(CoreModulesEnum::ACL_REPOSITORY);
    }
}
