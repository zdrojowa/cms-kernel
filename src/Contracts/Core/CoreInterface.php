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
     * @return AclRepositoryInterface|null
     */
    public function aclRepository(): ?AclRepositoryInterface;

    /**
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

}
