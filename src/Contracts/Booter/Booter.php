<?php

namespace Zdrojowa\CmsKernel\Contracts\Booter;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Interface Booter
 * @package Zdrojowa\CmsKernel\Contracts\Booter
 */
interface Booter
{

    /**
     * Check if booter has any error from Core Modules
     *
     * @return bool
     */
    public function hasError(): bool;

    /**
     * Return all errors
     *
     * @return array|null
     */
    public function getErrors(): array;

    /**
     * Add error
     *
     * @param string $error
     *
     * @return Booter
     */
    public function addError(string $error): Booter;

    /**
     * Check if given Core Module is correctly booted
     *
     * @param CoreModules $coreModule
     *
     * @return bool
     */
    public function isCoreModuleBooted(CoreModules $coreModule): bool;

    /**
     * Mark Core Module as booted
     *
     * @param CoreModules $coreModule
     *
     * @return Booter
     */
    public function setCoreModuleBooted(CoreModules $coreModule): Booter;

    /**
     * Check if all Core Modules are correctly booted
     *
     * @return bool
     */
    public function allCoreModulesBooted(): bool;

    /**
     * Determine if can boot Core Modules
     * @return bool
     */
    public function canBoot(): bool;

    /**
     * Return array of Core Modules boot status
     *
     * @return Collection
     */
    public function getCoreModulesStatus(): Collection;

    /**
     * Return current version of mounted Booter
     *
     * @return string
     */
    public function getVersion(): string;

}
