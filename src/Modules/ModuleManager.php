<?php

namespace Zdrojowa\InvestmentCMS\Modules;

use Exception;
use Illuminate\Support\Collection;
use ReflectionException;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\InvestmentCMS\Events\Module\ModuleRegisterEvent;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;
use Zdrojowa\InvestmentCMS\Exceptions\Modules\ModuleConfigException;
use Zdrojowa\InvestmentCMS\Exceptions\Modules\ModuleInstanceException;
use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;

/**
 * Class ModuleManager
 * @package Zdrojowa\InvestmentCMS\Modules
 */
class ModuleManager implements ModuleManagerInterface
{
    /**
     * @var string
     */
    private $version = '0.0.1';

    /**
     * @var Collection $modules
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
     * @param string $name
     *
     * @param Module $module
     *
     * @return ModuleManagerInterface
     */
    public function addModule(string $name, Module $module): ModuleManagerInterface
    {
        $this->modules->put($name, $module);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ModuleManagerInterface|null
     */
    public function getModule(string $name): ?Module
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

    /**
     *
     * @throws Exception
     */
    public function initialize(): void
    {
        $modules = ConfigUtils::coreConfig(CoreEnum::MODULES_SECTION);
        $this->checkModulesConfigStructure($modules);
        foreach ($modules as  $module) {
            try {
                $module = app($module);

                $this->checkModuleInstance($module);

                $this->addModule($module->getName(), $module);

                event(new ModuleRegisterEvent($module));
            } catch (InvestmentCMSException | ReflectionException $exception) {
                dd($exception);
                report($exception);

                continue;
            }
        }
    }

    /**
     * @param $modules
     *
     * @return bool
     * @throws Exception
     */
    private function checkModulesConfigStructure($modules)
    {
        if (is_array($modules)) return true;

        throw new ModuleConfigException();
    }

    /**
     * @param $module
     *
     * @return bool
     * @throws Exception
     */
    private function checkModuleInstance($module)
    {
        if (is_subclass_of($module, Module::class)) return true;

        throw new ModuleInstanceException(get_class($module));
    }
}
