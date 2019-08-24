<?php

namespace Zdrojowa\CmsKernel\Providers;

use AclRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Zdrojowa\CmsKernel\Contracts\Acl\AclRepository;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Events\Core\AclRepositoryRegisterEvent;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class AclRepositoryServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
 */
class AclRepositoryServiceProvider extends ServiceProvider
{
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
}
