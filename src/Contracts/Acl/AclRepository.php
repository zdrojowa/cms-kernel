<?php

namespace Zdrojowa\InvestmentCMS\Contracts\Acl;

use Illuminate\Support\Collection;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Events\Module\ModuleAclPresenceRegisterEvent;
use Zdrojowa\InvestmentCMS\Exceptions\Acl\AclRepositoryHasPresenceException;

/**
 * Class AclRepository
 * @package Zdrojowa\InvestmentCMS\Contracts\Acl
 */
class AclRepository
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
     * @param Module $module
     * @param Collection $presence
     *
     * @return AclRepository
     * @throws AclRepositoryHasPresenceException
     */
    public function addPresence(Module $module, Collection $presence): AclRepository
    {
        if ($this->hasModulePresence($module->getName())) {
            throw new AclRepositoryHasPresenceException(get_class($module));
        }

        $aclModulePresence = new AclPresence($module->getAclAnchor(), $module->getAclName(), $presence);
        $this->presences->put($module->getName(), $aclModulePresence);

        event(new ModuleAclPresenceRegisterEvent($module, $aclModulePresence));

        return $this;
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
     * @return bool
     */
    public function hasModulePresence(string $moduleName): bool
    {
        return $this->presences->has($moduleName);
    }

    /**
     * @param string $moduleName
     *
     * @return AclPresence
     */
    public function getModulePresence(string $moduleName): AclPresence
    {
        if ($this->hasModulePresence($moduleName)) return $this->presences->get($moduleName);

        return null;
    }

    /**
     * @param string $presence
     *
     * @return AclPresence|null
     */
    public function get(string $presence): ?AclPresence
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
