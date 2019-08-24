<?php

namespace Zdrojowa\CmsKernel\Modules;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;

/**
 * Class ModuleManager
 * @package Zdrojowa\CmsKernel\Modules
 */
class ModuleManager implements ModuleManagerInterface
{

    /**
     * @var string
     */
    private $version = '0.0.1';

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
     * @param string $name
     *
     * @param ModuleInterface $module
     *
     * @return ModuleManagerInterface
     */
    public function addModule(string $name, ModuleInterface $module): ModuleManagerInterface
    {
        $this->modules->put($name, $module);

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
}
