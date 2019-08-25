<?php

namespace Zdrojowa\CmsKernel\Modules;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Exceptions\CmsExceptionHandler;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleConfigException;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleInstanceException;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

/**
 * Class ModuleManager
 * @package Zdrojowa\CmsKernel\Modules
 */
class ModuleManager implements ModuleManagerInterface
{

    /**
     * @var string
     */
    public $version = '0.0.2';

    /**
     * @var Collection
     */
    private $modules;

    /**
     * ModuleManager constructor.
     */
    public function __construct()
    {
        $this->modules = new Collection;
    }

    /**
     * Get current ModuleManager version
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Check if module exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        if ($this->modules->has($name)) return true;

        return false;
    }

    /**
     * @param ModuleInterface $module
     *
     * @return ModuleManagerInterface
     */
    public function addModule(ModuleInterface $module): ModuleManagerInterface
    {
        $module->loadConfig();

        $module->mapRoutes();
        $module->mapRoutes(true);

        $this->modules->put($module->name, $module);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ModuleManagerInterface|null
     */
    public function getModule(string $name): ?ModuleInterface
    {
        return $this->modules->get($name);
    }

    /**
     * @return Collection
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function initialize()
    {
        $modules = ConfigUtils::coreConfig(CoreEnum::MODULES_SECTION);

        try {
            $this->checkModulesConfigStructure($modules);
        } catch (ModuleConfigException $exception) {
            CmsExceptionHandler::handle($exception);
        }

        foreach ($modules as $module) {
            try {
                $module = app($module);
                $this->checkModuleInstance($module);
                $this->addModule($module);
            } catch (CmsKernelException $exception) {
                CmsExceptionHandler::handle($exception);
            }
        }
    }

    /**
     * @param $modules
     *
     * @return bool
     * @throws ModuleConfigException
     */
    protected function checkModulesConfigStructure($modules): bool
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
