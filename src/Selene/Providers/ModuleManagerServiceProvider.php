<?php

namespace Selene\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Selene\Contracts\Booter\Booter;
use Selene\Contracts\Modules\ModuleManager;
use Selene\Exceptions\CmsExceptionHandler;
use Selene\Modules\Exceptions\ModuleConfigNotFoundException;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\CoreModules;
use Selene\Support\Enums\Modules\Module as ModuleEnum;
use Selene\Support\Enums\Modules\ModuleConfig;
use Selene\Support\Facades\Variabler;
use Selene\Support\Modules\Module;

/**
 * Class ModuleManagerServiceProvider
 * @package Selene\Providers
 */
class ModuleManagerServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function boot()
    {
        if (!$this->booter()->allCoreModulesBooted()) return;

        $this->app->get(CoreModules::MODULE_MANAGER)->initialize();

        $this->publishModulesExtra();
    }

    /**
     *
     */
    public function register()
    {
        if (!$this->booter()->canBoot()) return;

        $this->registerModuleManager();
    }

    /**
     * @return ModuleManagerServiceProvider
     */
    protected function registerModuleManager(): ModuleManagerServiceProvider
    {
        $this->app->singleton(CoreModules::MODULE_MANAGER, Config::coreModules(CoreModules::MODULE_MANAGER()));
        $this->app->bind(ModuleManager::class, CoreModules::MODULE_MANAGER);

        $this->booter()->setCoreModuleBooted(CoreModules::MODULE_MANAGER());

        return $this;
    }

    /**
     * @return Booter
     */
    protected function booter(): Booter
    {
        return $this->app->get(CoreModules::BOOTER);
    }

    /**
     * @return ModuleManagerServiceProvider
     */
    protected function publishModulesExtra(): ModuleManagerServiceProvider
    {
        foreach ($this->moduleManager()->getModules() as $module) {
            try {
                $extraData = Module::config($module, ModuleConfig::EXTRA_FILE());
                if ($extraData) {
                    $module = new ReflectionClass($module);
                    $fileName = ModuleConfig::EXTRA_FILE;

                    $fileName = Variabler::make($fileName, $module);

                    $this->publishes([
                        dirname($module->getFileName()) . "/" . ModuleConfig::CONFIG_FOLDER . $fileName => base_path(ModuleEnum::CONFIG_DIR) . "/$fileName",
                    ]);
                }
            } catch (ReflectionException | ModuleConfigNotFoundException $e) {
                CmsExceptionHandler::handle($e);
            }


        }

        return $this;
    }

    /**
     * @return ModuleManager
     */
    protected function moduleManager(): ModuleManager
    {
        return $this->app->get(CoreModules::MODULE_MANAGER);
    }
}
