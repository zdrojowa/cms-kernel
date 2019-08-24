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
     * @return bool
     */
    public function hasError(): bool;

    /**
     * @return array|null
     */
    public function getErrors(): ?array;

    /**
     * @param string $error
     *
     * @return BooterInterface
     */
    public function addError(string $error): BooterInterface;

    /**
     * @param CoreModulesEnum $coreModule
     *
     * @return bool
     */
    public function isCoreModuleBooted(CoreModulesEnum $coreModule): bool;

    /**
     * @param CoreModulesEnum $coreModule
     *
     * @return BooterInterface
     */
    public function setCoreModuleBooted(CoreModulesEnum $coreModule): BooterInterface;

    /**
     * @return bool
     */
    public function allCoreModulesBooted(): bool;

    /**
     * @return bool
     */
    public function canBoot(): bool;

    /**
     * @return Collection
     */
    public function getCoreModulesStatus(): Collection;

}
