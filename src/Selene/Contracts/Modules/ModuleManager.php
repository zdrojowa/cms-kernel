<?php

namespace Selene\Contracts\Modules;

use Illuminate\Support\Collection;

/**
 * Interface ModuleManager
 * @package Selene\Contracts\Modules
 */
interface ModuleManager
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
     * @param Module $module
     *
     * @return ModuleManager
     */
    public function addModule(Module $module): ModuleManager;

    /**
     * @param string $name
     *
     * @return ModuleManager|null
     */
    public function getModule(string $name): ?Module;

    /**
     * @return Collection
     */
    public function getModules(): Collection;

    /**
     * @return mixed
     */
    public function initialize();
}
