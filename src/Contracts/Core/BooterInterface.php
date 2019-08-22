<?php

namespace Zdrojowa\CmsKernel\Contracts\Core;

/**
 * Interface BooterInterface
 * @package Zdrojowa\CmsKernel\Contracts\Core
 */
interface BooterInterface
{
    /**
     * @return bool
     */
    public function isCmsEnabled(): bool;

    /**
     * @return BooterInterface
     */
    public function markCmsEnabled(): BooterInterface;

    /**
     * @return bool
     */
    public function canCmsBoot(): bool;
}
