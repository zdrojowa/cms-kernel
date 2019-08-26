<?php

namespace Selene\Providers;

use Illuminate\Support\ServiceProvider;
use Selene\Booter\Events\BooterRegisterEvent;
use Selene\Contracts\Booter\Booter;
use Selene\Contracts\Core\Core;
use Selene\Core\Events\CoreBootedEvent;
use Selene\Core\Events\CoreRegisterEvent;
use Selene\Menu\Events\MenuRepositoryRegisterEvent;
use Selene\Menu\MenuRepository;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core as CoreEnum;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class CoreServiceProvider
 * @package Selene\Providers
 */
class CoreServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->registerObligatoryCommands();

        if (!$this->booter()->allCoreModulesBooted()) return;

        $this->publishConfig()->registerCommands()->registerMigrations();

        event(new CoreBootedEvent(app(CoreModules::CORE)));
    }

    /**
     *
     */
    public function register()
    {
        $this->registerConfig()->registerBooterModule();

        if (!$this->booter()->canBoot()) return;

        $this->registerCoreModule()->registerMenuRepository();
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerBooterModule(): CoreServiceProvider
    {
        $this->app->singleton(CoreModules::BOOTER, Config::coreModules(CoreModules::BOOTER()));
        $this->app->bind(Booter::class, CoreModules::BOOTER);

        event(new BooterRegisterEvent(app(CoreModules::BOOTER)));

        $this->booter()->setCoreModuleBooted(CoreModules::BOOTER());

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerCoreModule(): CoreServiceProvider
    {
        $this->app->singleton(CoreModules::CORE, Config::coreModules(CoreModules::CORE()));
        $this->app->bind(Core::class, CoreModules::CORE);

        event(new CoreRegisterEvent(app(CoreModules::CORE)));

        $this->booter()->setCoreModuleBooted(CoreModules::CORE());

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerMenuRepository(): CoreServiceProvider
    {
        $this->app->singleton(CoreModules::MENU_REPOSITORY, MenuRepository::class);

        event(new MenuRepositoryRegisterEvent(app(CoreModules::MENU_REPOSITORY)));

        $this->booter()->setCoreModuleBooted(CoreModules::MENU_REPOSITORY());

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerCommands(): CoreServiceProvider
    {
        if ($this->app->runningInConsole()) {
            $this->commands(Config::get(CoreEnum::COMMANDS));
        }

        return $this;
    }

    /**
     * @return CoreServiceProvider
     */
    protected function registerObligatoryCommands(): CoreServiceProvider
    {
        if ($this->app->runningInConsole()) {
            $this->commands(Config::get(CoreEnum::OBLIGATORY_COMMANDS));
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
        $this->mergeConfigFrom(__DIR__ . '/../../config/cms-core.php', CoreEnum::CONFIG);

        return $this;
    }

    /**
     * @return Booter
     */
    public function booter(): Booter
    {
        return $this->app->get(CoreModules::BOOTER);
    }

}
