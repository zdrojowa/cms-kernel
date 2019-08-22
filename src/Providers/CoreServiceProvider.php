<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use Zdrojowa\CmsKernel\Contracts\Acl\AclRepository;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Events\Booter\BooterRegisterEvent;
use Zdrojowa\CmsKernel\Events\Core\AclRepositoryRegisterEvent;
use Zdrojowa\CmsKernel\Events\Core\CoreBootedEvent;
use Zdrojowa\CmsKernel\Events\Core\CoreRegisterEvent;
use Zdrojowa\CmsKernel\Events\Core\MenuRepositoryRegisterEvent;
use Zdrojowa\CmsKernel\Facades\Booter;
use Zdrojowa\CmsKernel\Menu\MenuRepository;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class CoreServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
 */
class CoreServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->publishConfig()->registerCommands()->registerMigrations();

        event(new CoreBootedEvent(app(CoreModulesEnum::CORE)));
        Booter::markCmsEnabled();
    }

    /**
     *
     */
    public function register()
    {
        $this->registerConfig()->registerBooterModule();

        if (!Booter::canCmsBoot()) return;

        $this->registerCoreModule()->registerAclRepository()->registerMenuRepository();
    }

    /**
     * @return CoreServiceProvider
     */
    protected function publishConfig(): CoreServiceProvider
    {
        $this->publishes([
            __DIR__ . '/../../config/cms-core.php' => config_path('cms-core.php'),
        ]);

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerConfig(): CoreServiceProvider
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cms-core.php', CoreEnum::CMS_CONFIG);

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerBooterModule(): CoreServiceProvider
    {
        $this->app->singleton(CoreModulesEnum::BOOTER, ConfigUtils::coreModules(CoreModulesEnum::BOOTER()));
        $this->app->bind(BooterInterface::class, CoreModulesEnum::BOOTER);

        event(new BooterRegisterEvent(app(CoreModulesEnum::BOOTER)));

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerCoreModule(): CoreServiceProvider
    {
        $this->app->singleton(CoreModulesEnum::CORE, ConfigUtils::coreModules(CoreModulesEnum::CORE()));
        $this->app->bind(CoreInterface::class, CoreModulesEnum::CORE);

        event(new CoreRegisterEvent(app(CoreModulesEnum::CORE)));

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerAclRepository(): CoreServiceProvider
    {
        $this->app->singleton(CoreModulesEnum::ACL_REPOSITORY, AclRepository::class);

        event(new AclRepositoryRegisterEvent(app(CoreModulesEnum::ACL_REPOSITORY)));

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerMenuRepository(): CoreServiceProvider
    {
        $this->app->singleton(CoreModulesEnum::MENU_REPOSITORY, MenuRepository::class);

        event(new MenuRepositoryRegisterEvent(app(CoreModulesEnum::MENU_REPOSITORY)));

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerCommands(): CoreServiceProvider
    {
        if ($this->app->runningInConsole()) {
            $this->commands(ConfigUtils::coreConfig(CoreEnum::CORE_COMMANDS_SECTION));
        }

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerMigrations(): CoreServiceProvider
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        return $this;
    }
}
