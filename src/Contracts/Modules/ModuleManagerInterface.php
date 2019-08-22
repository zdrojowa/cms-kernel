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
     *
     */
    public function initialize(): void;

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
     * @param string $name
     *
     * @param Module $module
     *
     * @return ModuleManagerInterface
     */
    public function addModule(string $name, Module $module): ModuleManagerInterface;

    /**
     * @param string $name
     *
     * @return ModuleManagerInterface|null
     */
    public function getModule(string $name): ?Module;

    /**
     * @return Collection
     */
    public function getModules(): Collection;
}
