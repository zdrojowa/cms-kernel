<?php

namespace Selene\Contracts\Core;

use Selene\Contracts\Acl\Repository\AclRepository;
use Selene\Contracts\Modules\ModuleManager;

/**
 * Interface Core
 * @package Selene\Contracts\Core
 */
interface Core
{
    /**
     * Get registered aclRepository in IoC Container
     *
     * @return AclRepository|null
     */
    public function aclRepository(): ?AclRepository;

    /**
     * Get registered moduleManager in IoC Container
     *
     * @return ModuleManager|null
     */
    public function moduleManager(): ?ModuleManager;

    /**
     * @param $level
     * @param $message
     * @param array|null $context
     *
     * @return Core
     */
    public function log($level, $message, array $context = null): Core;

    /**
     * Get current version of mounted core
     *
     * @return string
     */
    public function getVersion(): string;

}
