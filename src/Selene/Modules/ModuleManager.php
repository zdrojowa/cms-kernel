<?php

namespace Selene\Modules;

use Illuminate\Support\Collection;
use Selene\Contracts\Modules\Module as ModuleContract;
use Selene\Contracts\Modules\ModuleManager as ModuleManagerContract;
use Selene\Exceptions\CmsExceptionHandler;
use Selene\Exceptions\CmsKernelException;
use Selene\Modules\Exceptions\ModuleConfigException;
use Selene\Modules\Exceptions\ModuleInstanceException;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

/**
 * Class ModuleManager
 * @package Selene\Modules
 */
class ModuleManager implements ModuleManagerContract
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
     * @param ModuleContract $module
     *
     * @return ModuleManager
     */
    public function addModule(ModuleContract $module): ModuleManagerContract
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
     * @return ModuleManager|null
     */
    public function getModule(string $name): ?ModuleContract
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
        $modules = Config::get(Core::MODULES);

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
        if (is_subclass_of($module, Module::class)) return true;

        throw new ModuleInstanceException(get_class($module));
    }
}
