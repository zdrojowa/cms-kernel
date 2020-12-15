<?php

namespace Selene\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Selene\Acl\Events\AclRepositoryRegisterEvent;
use Selene\Contracts\Acl\Repository\AclRepository;
use Selene\Contracts\Booter\Booter;
use Selene\Contracts\Modules\ModuleManager;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class AclRepositoryServiceProvider
 * @package Selene\Providers
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

        foreach ($this->aclRepository()->getAclPresencesAnchors() as $anchor) {
            Gate::define($anchor, function($user) use ($anchor) {
               return $user->hasPermission($anchor);
            });
        }

        Blade::if('permission', function($anchor) {
            return Gate::allows($anchor);
        });
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
        $this->app->instance(AclRepository::class, CoreModules::ACL_REPOSITORY());

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
