<?php

namespace Selene\Menu;

use Illuminate\Support\Collection;
use Selene\Acl\Exceptions\AclRepositoryHasPresenceException;
use Selene\Contracts\Modules\Module;
use Selene\Modules\Events\ModuleMenuPresenceRegisterEvent;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

/**
 * Class MenuRepository
 * @package Selene\Menu
 */
class MenuRepository
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
     * @return MenuRepository
     * @throws AclRepositoryHasPresenceException
     */
    public function addPresence(Module $module, Collection $presence): MenuRepository
    {
        if ($this->hasModulePresence($module->getName())) {
            throw new AclRepositoryHasPresenceException(get_class($module));
        }

        $menuItemPresence = new MenuPresence($module->getAclAnchor(), $module->getAclName(), null, null, $presence);
        $this->presences->put($module->getName(), $menuItemPresence);

        event(new ModuleMenuPresenceRegisterEvent($module, $menuItemPresence));

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPresences(): Collection
    {
        return $this->presences->sortBy(function($presence) {
            return array_search($presence->getAnchor(), Config::get(Core::MENU_ORDER) ?? []);
        });
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
     * @return MenuPresence
     */
    public function getModulePresence(string $moduleName): MenuPresence
    {
        if ($this->hasModulePresence($moduleName)) return $this->presences->get($moduleName);

        return null;
    }

    /**
     * @param string $presence
     *
     * @return mixed|null
     */
    public function get(string $presence): ?MenuPresence
    {
        $exploded = explode('.', $presence);
        $currentPresence = $this->presences->get($exploded[0]);

        array_shift($exploded);

        foreach ($exploded as $toSearch) {
            if ($currentPresence !== null) {
                if ($currentPresence->getChildren() === null) return null;

                $currentPresence = $currentPresence->getChildren()->get($toSearch);
            }
        }

        return $currentPresence;
    }
}
