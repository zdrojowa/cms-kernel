<?php

namespace Zdrojowa\Investmentcms\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Zdrojowa\InvestmentCMS\Contracts\Core\BooterInterface;
use Zdrojowa\InvestmentCMS\Contracts\Core\CoreInterface;
use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\InvestmentCMS\Exceptions\Modules\ModuleConfigNotFoundException;
use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\InvestmentCMS\Utils\Module\ModuleUtils;

/**
 * Class ModuleManagerServiceProvider
 * @package Zdrojowa\Investmentcms\Providers
 */
class ModuleManagerServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function boot()
    {
        if (!$this->booter()->canCmsBoot() || !$this->core()->hasModuleManager()) return;

        $this->core()->getModuleManager()->initialize();
        $this->publishModulesExtra();
    }

    /**
     *
     */
    public function register()
    {
        if (!$this->booter()->canCmsBoot()) return;

        $this->registerModuleManager();
        $this->core()->setModuleManager(app(ModuleManagerInterface::class));
    }

    /**
     * @return ModuleManagerServiceProvider
     */
    protected function registerModuleManager(): ModuleManagerServiceProvider
    {
        $this->app->singleton(CoreModulesEnum::MODULE_MANAGER, ConfigUtils::coreModules(CoreModulesEnum::MODULE_MANAGER()));
        $this->app->bind(ModuleManagerInterface::class, CoreModulesEnum::MODULE_MANAGER);

        return $this;
    }

    /**
     * @return CoreInterface
     */
    protected function core(): CoreInterface
    {
        return app(CoreModulesEnum::CORE);
    }

    /**
     * @return BooterInterface
     */
    protected function booter(): BooterInterface
    {
        return app(CoreModulesEnum::BOOTER);
    }

    /**
     * @return ModuleManagerServiceProvider
     */
    protected function publishModulesExtra(): ModuleManagerServiceProvider
    {
        foreach ($this->core()->getModuleManager()->getModules() as $module) {
            try {
                $extraData = ModuleUtils::moduleConfig($module, ModuleConfigEnum::MODULE_EXTRA_FILE());

                if ($extraData) {
                    $module = new ReflectionClass($module);
                    $fileName = ModuleConfigEnum::MODULE_EXTRA_FILE;

                    $fileName = str_replace('%name%', $module->getShortName(), $fileName);

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
}
