<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleConfigNotFoundException;
use Zdrojowa\CmsKernel\Facades\Variabler;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;
use Zdrojowa\CmsKernel\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\CmsKernel\Utils\Module\ModuleUtils;

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

        $this->app->get(CoreModulesEnum::MODULE_MANAGER)->initialize();

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
        $this->app->singleton(CoreModulesEnum::MODULE_MANAGER, ConfigUtils::coreModules(CoreModulesEnum::MODULE_MANAGER()));
        $this->app->bind(ModuleManagerInterface::class, CoreModulesEnum::MODULE_MANAGER);

        $this->booter()->setCoreModuleBooted(CoreModulesEnum::MODULE_MANAGER());

        return $this;
    }

    /**
     * @return BooterInterface
     */
    protected function booter(): BooterInterface
    {
        return $this->app->get(CoreModulesEnum::BOOTER);
    }

    /**
     * @return ModuleManagerServiceProvider
     */
    protected function publishModulesExtra(): ModuleManagerServiceProvider
    {
        foreach ($this->moduleManager()->getModules() as $module) {
            try {
                $extraData = ModuleUtils::moduleConfig($module, ModuleConfigEnum::MODULE_EXTRA_FILE());
                if ($extraData) {
                    $module = new ReflectionClass($module);
                    $fileName = ModuleConfigEnum::MODULE_EXTRA_FILE;

                    $fileName = Variabler::make($fileName, $module);

                    $this->publishes([
                        dirname($module->getFileName()) . "/" . ModuleConfigEnum::MODULES_CONFIG_FOLDER . $fileName => base_path(CoreEnum::MODULES_CONFIG_DIR) . "/$fileName",
                    ]);
                }
            } catch (ReflectionException | ModuleConfigNotFoundException $e) {
                report($e);
            }


        }

        return $this;
    }

    /**
     * @return ModuleManagerInterface
     */
    protected function moduleManager(): ModuleManagerInterface
    {
        return $this->app->get(CoreModulesEnum::MODULE_MANAGER);
    }
}
