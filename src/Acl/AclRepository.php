<?php

namespace Zdrojowa\CmsKernel\Acl;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Acl\AclPresenceInterface;
use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Exceptions\Acl\AclRepositoryHasPresenceException;

/**
 * Class AclRepository
 * @package Zdrojowa\CmsKernel\Acl
 */
class AclRepository implements AclRepositoryInterface
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
     * @param AclPresenceInterface $presence
     *
     * @return AclRepositoryInterface
     * @throws AclRepositoryHasPresenceException
     */
    public function addPresence(AclPresenceInterface $presence): AclRepositoryInterface
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
     * @return AclPresenceInterface|null
     */
    public function getMainPresence(string $moduleName): ?AclPresenceInterface
    {
        if ($this->hasMainPresence($moduleName)) return $this->presences->get($moduleName);

        return null;
    }

    /**
     * @param string $presence
     *
     * @return AclPresenceInterface|null
     */
    public function get(string $presence): ?AclPresenceInterface
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
