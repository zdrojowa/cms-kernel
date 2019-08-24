<?php

namespace Zdrojowa\CmsKernel\Contracts\Core;

use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;

/**
 * Interface CoreInterface
 * @package Zdrojowa\CmsKernel\Contracts\Core
 */
interface CoreInterface
{
    /**
     * Get registered aclRepository in IoC Container
     *
     * @return AclRepositoryInterface|null
     */
    public function aclRepository(): ?AclRepositoryInterface;

    /**
     * Get registered moduleManager in IoC Container
     *
     * @return ModuleManagerInterface|null
     */
    public function moduleManager(): ?ModuleManagerInterface;

    /**
     * @param $level
     * @param $message
     * @param array|null $context
     *
     * @return CoreInterface
     */
    public function log($level, $message, array $context = null): CoreInterface;

    /**
     * Get current version of mounted core
     *
     * @return string
     */
    public function getVersion(): string;

}
