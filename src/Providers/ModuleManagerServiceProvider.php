<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Events\Module\ModuleRegisterEvent;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleConfigException;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleConfigNotFoundException;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleInstanceException;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;
use Zdrojowa\CmsKernel\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\CmsKernel\Utils\Module\ModuleUtils;
use Zdrojowa\CmsKernel\Utils\Variabler\Variabler;

/**
 * Class ModuleManagerServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
 */
class ModuleManagerServiceProvider extends ServiceProvider
{

    /**
     * ModuleManagerServiceProvider constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->modules = ConfigUtils::coreConfig(CoreEnum::MODULES_SECTION);
    }

    /**
     *
     */
    public function boot()
    {
        if (!$this->booter()->allCoreModulesBooted()) return;

        $this->initializeModules();
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

                    $fileName = Variabler::replace($module, $fileName);

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

    /**
     * @return ModuleManagerServiceProvider
     * @throws ModuleConfigException
     */
    protected function initializeModules(): ModuleManagerServiceProvider
    {
        $this->checkModulesConfigStructure($this->modules);

        foreach ($this->modules as $module) {
            try {
                $module = app($module);

                $this->checkModuleInstance($module);

                $module->loadConfig();
                $module->mapRoutes();
                $module->mapRoutes(true);

                $this->moduleManager()->addModule($module->getName(), $module);

                event(new ModuleRegisterEvent($module));
            } catch (CmsKernelException | ReflectionException $exception) {
                dd($exception);
                report($exception);

                continue;
            }
        }

        return $this;
    }

    /**
     * @param $modules
     *
     * @return bool
     * @throws ModuleConfigException
     */
    protected function checkModulesConfigStructure($modules)
    {
        if (is_array($modules)) return true;

        throw new ModuleConfigException();
    }

    /**
     * @param $module
     *
     * @return bool
     * @throws ModuleInstanceException
     */
    protected function checkModuleInstance($module)
    {
        if (is_subclass_of($module, ModuleInterface::class)) return true;

        throw new ModuleInstanceException(get_class($module));
    }
}
