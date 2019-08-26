<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use Zdrojowa\CmsKernel\Acl\Events\AclRepositoryRegisterEvent;
use Zdrojowa\CmsKernel\Contracts\Acl\Repository\AclRepository;
use Zdrojowa\CmsKernel\Contracts\Booter\Booter;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class AclRepositoryServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
 */
class AclRepositoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if (!$this->booter()->allCoreModulesBooted()) return;

        foreach ($this->moduleManager()->getModules() as $module) {
            if ($module->getAclPresence() === null) continue;

            $this->aclRepository()->addPresence($module->getAclPresence());
        }
    }

    /**
     *
     */
    public function register()
    {
        if (!$this->booter()->canBoot()) return;

        $this->registerAclRepository();
    }

    /**
     * @return AclRepositoryServiceProvider
     */
    protected function registerAclRepository(): AclRepositoryServiceProvider
    {
        $this->app->singleton(CoreModules::ACL_REPOSITORY, Config::coreModules(CoreModules::ACL_REPOSITORY()));
        $this->app->bind(AclRepository::class, CoreModules::ACL_REPOSITORY());

        event(new AclRepositoryRegisterEvent(app(CoreModules::ACL_REPOSITORY)));

        $this->booter()->setCoreModuleBooted(CoreModules::ACL_REPOSITORY());

        return $this;
    }

    /**
     * @return Booter
     */
    protected function booter(): Booter
    {
        return $this->app->get(CoreModules::BOOTER);
    }

    protected function aclRepository(): AclRepository
    {
        return $this->app->get(CoreModules::ACL_REPOSITORY);
    }

    protected function moduleManager(): ModuleManager
    {
        return $this->app->get(CoreModules::MODULE_MANAGER);
    }
}
