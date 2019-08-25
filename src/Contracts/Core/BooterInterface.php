<?php

namespace Zdrojowa\CmsKernel\Contracts\Core;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Interface BooterInterface
 * @package Zdrojowa\CmsKernel\Contracts\Core
 */
interface BooterInterface
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
     * @return BooterInterface
     */
    public function addError(string $error): BooterInterface;

    /**
     * Check if given Core Module is correctly booted
     *
     * @param CoreModulesEnum $coreModule
     *
     * @return bool
     */
    public function isCoreModuleBooted(CoreModulesEnum $coreModule): bool;

    /**
     * Mark Core Module as booted
     *
     * @param CoreModulesEnum $coreModule
     *
     * @return BooterInterface
     */
    public function setCoreModuleBooted(CoreModulesEnum $coreModule): BooterInterface;

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
