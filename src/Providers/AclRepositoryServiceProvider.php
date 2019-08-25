<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Events\Core\AclRepositoryRegisterEvent;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

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
        $this->app->singleton(CoreModulesEnum::ACL_REPOSITORY, ConfigUtils::coreModules(CoreModulesEnum::ACL_REPOSITORY()));
        $this->app->bind(AclRepositoryInterface::class, CoreModulesEnum::ACL_REPOSITORY());

        event(new AclRepositoryRegisterEvent(app(CoreModulesEnum::ACL_REPOSITORY)));

        $this->booter()->setCoreModuleBooted(CoreModulesEnum::ACL_REPOSITORY());

        return $this;
    }

    /**
     * @return BooterInterface
     */
    protected function booter(): BooterInterface
    {
        return $this->app->get(CoreModulesEnum::BOOTER);
    }

    protected function aclRepository(): AclRepositoryInterface
    {
        return $this->app->get(CoreModulesEnum::ACL_REPOSITORY);
    }

    protected function moduleManager(): ModuleManagerInterface
    {
        return $this->app->get(CoreModulesEnum::MODULE_MANAGER);
    }
}
