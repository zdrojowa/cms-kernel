<?php

namespace Selene\Contracts\Acl\Repository;

use Illuminate\Support\Collection;
use Selene\Contracts\Acl\Presence\AclPresence;

/**
 * Interface AclRepository
 * @package Selene\Contracts\Acl\Repository
 */
interface AclRepository
{
    /**
     * @param AclPresence $presence
     *
     * @return AclRepository
     */
    public function addPresence(AclPresence $presence): AclRepository;

    /**
     * @return Collection
     */
    public function getPresences(): Collection;

    /**
     * @param string $moduleName
     *
     * @return AclPresence|null
     */
    public function getMainPresence(string $moduleName): ?AclPresence;

    /**
     * @param string $moduleName
     *
     * @return bool
     */
    public function hasMainPresence(string $moduleName): bool;

    /**
     * @param string $presence
     *
     * @return AclPresence|null
     */
    public function get(string $presence): ?AclPresence;
}
