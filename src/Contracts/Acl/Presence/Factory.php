<?php

namespace Zdrojowa\CmsKernel\Contracts\Acl\Presence;

/**
 * Interface Factory
 * @package Zdrojowa\CmsKernel\Contracts\Acl\Presence
 */
interface Factory
{
    /**
     * @return AclPresence
     */
    public function create(): AclPresence;
}
