<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Zdrojowa\CmsKernel\Contracts\Booter\Booter;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Exceptions\CmsExceptionHandler;
use Zdrojowa\CmsKernel\Modules\Exceptions\ModuleConfigNotFoundException;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;
use Zdrojowa\CmsKernel\Support\Enums\Modules\Module as ModuleEnum;
use Zdrojowa\CmsKernel\Support\Enums\Modules\ModuleConfig;
use Zdrojowa\CmsKernel\Support\Facades\Variabler;
use Zdrojowa\CmsKernel\Support\Modules\Module;

/**
 * Class ModuleManagerServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
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
