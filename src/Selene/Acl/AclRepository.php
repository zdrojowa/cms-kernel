<?php

namespace Selene\Acl;

use Illuminate\Support\Collection;
use RecursiveIteratorIterator;
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

    /**
     * @return array
     */
    public function getAclPresencesAnchors(): array
    {
        $anchors = [];

        $repositoryIterator = new RecursiveIteratorIterator(new AclPresenceIterator($this->getPresences()->toArray()), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($repositoryIterator as $presence) {
            if($repositoryIterator->getDepth() !== 0) {
                array_push($anchors, $this->makeAnchor($repositoryIterator, $presence));
            }
        }

        return $anchors;
    }

    /**
     * @param RecursiveIteratorIterator $iterator
     * @param AclPresenceContract $presence
     *
     * @return string
     */
    protected function makeAnchor(RecursiveIteratorIterator $iterator, AclPresenceContract $presence)
    {
        $depth = 0;
        $anchor = '';

        while ($depth !== $iterator->getDepth()) {
            if ($depth !== 0) $anchor .= '.';

            $anchor .= $iterator->getSubIterator($depth)->current()->getAnchor();
            $depth++;
        }

        $anchor .= '.' . $presence->getAnchor();

        return $anchor;
    }
    
    public function getAnchor(AclPresenceContract $presence): string
    {
        $repositoryIterator = new RecursiveIteratorIterator(new AclPresenceIterator($this->getPresences()->toArray()), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($repositoryIterator as $iteratorPresence) {
            if ($iteratorPresence === $presence) {
                return $this->makeAnchor($repositoryIterator, $presence);
            }
        }

        return '';
    }
}
