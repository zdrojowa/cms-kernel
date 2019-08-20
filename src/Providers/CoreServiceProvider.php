<?php

namespace Zdrojowa\InvestmentCMS\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Zdrojowa\InvestmentCMS\Console\Commands\ListModuleCommand;
use Zdrojowa\InvestmentCMS\Contracts\Acl\AclRepository;
use Zdrojowa\InvestmentCMS\Contracts\Core\BooterInterface;
use Zdrojowa\InvestmentCMS\Contracts\Core\CoreInterface;
use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\InvestmentCMS\Events\Booter\BooterRegisterEvent;
use Zdrojowa\InvestmentCMS\Events\Core\AclRepositoryRegisterEvent;
use Zdrojowa\InvestmentCMS\Events\Core\CoreBootedEvent;
use Zdrojowa\InvestmentCMS\Events\Core\CoreRegisterEvent;
use Zdrojowa\InvestmentCMS\Facades\Booter;
use Zdrojowa\InvestmentCMS\Facades\Core;
use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;

class CoreServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->publishConfig();

        Core::getModuleManager()->initialize();

        Booter::markCmsEnabled();

        $this->registerCommands()->registerMigrations();

        event(new CoreBootedEvent(app(CoreModulesEnum::CORE)));

        Schema::defaultStringLength(191);
    }

    /**
     *
     */
    public function register()
    {
        $this->registerConfig()->registerBooterModule();

        if (!Booter::canCmsBoot()) return;

        $this->registerCoreModule();
        $this->registerAclRepository();

        Core::setModuleManager(app(ConfigUtils::coreModules(CoreModulesEnum::MODULE_MANAGER())));
    }

    /**
     * @return CoreServiceProvider
     */
    protected function publishConfig(): CoreServiceProvider
    {
        $this->publishes([
            __DIR__ . '/../../config/cms-core.php' => config_path('cms-core.php')
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

    protected function registerAclRepository(): CoreServiceProvider
    {
        $this->app->singleton(CoreModulesEnum::ACL_REPOSITORY, AclRepository::class);

        event(new AclRepositoryRegisterEvent(app(CoreModulesEnum::ACL_REPOSITORY)));

        return $this;
    }

    protected function registerCommands(): CoreServiceProvider
    {
        if($this->app->runningInConsole()) {
            $this->commands(ConfigUtils::coreConfig(CoreEnum::CORE_COMMANDS_SECTION));
        }
        return $this;
    }

    protected function registerMigrations(): CoreServiceProvider
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        return $this;
    }
}
