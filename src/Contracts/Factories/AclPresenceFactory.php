<?php

namespace Zdrojowa\CmsKernel\Contracts\Factories;

use Zdrojowa\CmsKernel\Contracts\Acl\AclPresenceInterface;

/**
 * Interface AclPresenceFactory
 * @package Zdrojowa\CmsKernel\Contracts\Factories
 */
interface AclPresenceFactory
{
    /**
     * @return AclPresenceInterface
     */
    public function create(): AclPresenceInterface;
}
