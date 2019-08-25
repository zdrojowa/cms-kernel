<?php

namespace Zdrojowa\CmsKernel\Contracts\Modules;

use Illuminate\Support\Collection;

/**
 * Interface ModuleManagerInterface
 * @package Zdrojowa\CmsKernel\Contracts\Modules
 */
interface ModuleManagerInterface
{

    /**
     * Get current ModuleManager version
     * @return string
     */
    public function version(): string;

    /**
     * Check if module exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * @param ModuleInterface $module
     *
     * @return ModuleManagerInterface
     */
    public function addModule(ModuleInterface $module): ModuleManagerInterface;

    /**
     * @param string $name
     *
     * @return ModuleManagerInterface|null
     */
    public function getModule(string $name): ?ModuleInterface;

    /**
     * @return Collection
     */
    public function getModules(): Collection;

    public function initialize();
}
