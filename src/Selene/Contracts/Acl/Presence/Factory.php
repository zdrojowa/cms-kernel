<?php

namespace Selene\Contracts\Acl\Presence;

/**
 * Interface Factory
 * @package Selene\Contracts\Acl\Presence
 */
interface Factory
{
    /**
     * @return AclPresence
     */
    public function create(): AclPresence;
}
