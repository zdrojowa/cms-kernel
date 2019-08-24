<?php

namespace Zdrojowa\CmsKernel\Contracts\Acl;

use Illuminate\Support\Collection;

/**
 * Interface AclRepositoryInterface
 * @package Zdrojowa\CmsKernel\Contracts\Acl
 */
interface AclRepositoryInterface
{
    /**
     * @param AclPresenceInterface $presence
     *
     * @return AclRepositoryInterface
     */
    public function addPresence(AclPresenceInterface $presence): AclRepositoryInterface;

    /**
     * @return Collection
     */
    public function getPresences(): Collection;

    /**
     * @param string $moduleName
     *
     * @return AclPresenceInterface|null
     */
    public function getMainPresence(string $moduleName): ?AclPresenceInterface;

    /**
     * @param string $moduleName
     *
     * @return bool
     */
    public function hasMainPresence(string $moduleName): bool;

    /**
     * @param string $presence
     *
     * @return AclPresenceInterface|null
     */
    public function get(string $presence): ?AclPresenceInterface;
}
