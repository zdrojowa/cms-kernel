<?php

namespace Selene\Acl;

use Illuminate\Support\Collection;
use Selene\Acl\Exceptions\AclRepositoryHasPresenceException;
use Selene\Contracts\Acl\Repository\AclRepository as AclRepositoryContract;
use Selene\Contracts\Acl\Presence\AclPresence as AclPresenceContract;

/**
 * Class AclRepository
 * @package Selene\Acl
 */
class AclRepository implements AclRepositoryContract
{

    /**
     * @var Collection
     */
    protected $presences;

    /**
     * AclRepository constructor.
     */
    public function __construct()
    {
        $this->presences = new Collection();
    }

    /**
     * @param AclPresenceContract $presence
     *
     * @return AclRepository
     * @throws AclRepositoryHasPresenceException
     */
    public function addPresence(AclPresenceContract $presence): AclRepositoryContract
    {
        if ($this->hasMainPresence($presence->getName())) throw new AclRepositoryHasPresenceException($presence->getName());

        $this->presences->put($presence->getName(), $presence);

        return $this;
    }

    /**
     * @param string $moduleName
     *
     * @return bool
     */
    public function hasMainPresence(string $moduleName): bool
    {
        return $this->presences->has($moduleName);
    }

    /**
     * @return Collection
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    /**
     * @param string $moduleName
     *
     * @return AclPresence|null
     */
    public function getMainPresence(string $moduleName): ?AclPresenceContract
    {
        if ($this->hasMainPresence($moduleName)) return $this->presences->get($moduleName);

        return null;
    }

    /**
     * @param string $presence
     *
     * @return AclPresence|null
     */
    public function get(string $presence): ?AclPresenceContract
    {
        $exploded = explode('.', $presence);
        $currentPresence = $this->presences->get($exploded[0]);
        array_shift($exploded);
        foreach ($exploded as $toSearch) {
            if ($currentPresence === null || $currentPresence->getChildren() === null) return null;
            $currentPresence = $currentPresence->getChildren()->get($toSearch);
        }

        return $currentPresence;
    }

}