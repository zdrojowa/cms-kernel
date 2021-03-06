<?php

namespace Selene\Acl\Factories;

use Illuminate\Support\Collection;
use Selene\Acl\AclPresence;
use Selene\Acl\Exceptions\AclPresenceDataException;
use Selene\Contracts\Acl\Presence\AclPresence as AclPresenceContract;
use Selene\Contracts\Acl\Presence\Factory;
use Selene\Contracts\Modules\Module;
use Illuminate\Support\Facades\Validator;

/**
 * Class AclPresenceFactory
 * @package Selene\Acl\Factories
 */
class AclPresenceFactory implements Factory
{

    /**
     * @var Module
     */
    private $module;

    /**
     * @var array
     */
    protected static $rules = [
        'name' => 'string',
        'children' => 'sometimes|array',
    ];

    /**
     * DataArrayAclPresenceFactory constructor.
     *
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * @return AclPresence
     * @throws AclPresenceDataException
     */
    public function create(): AclPresenceContract
    {
        return new AclPresence($this->module->getAclAnchor(), $this->module->getAclName(), self::createChildren($this->module->getPermissions()));
    }

    /**
     * @param array $data
     *
     * @return Collection|null
     * @throws AclPresenceDataException
     */
    public function createChildren(array $data = []): ?Collection
    {
        $aclPresences = new Collection();

        foreach ($data as $anchor => $probablyAclPresence) {
            if (!self::checkStructure($probablyAclPresence ?? [])) {
                throw new AclPresenceDataException([$this->module->getName()]);
            }

            $aclPresence = new AclPresence($anchor, $probablyAclPresence['name']);

            if (isset($probablyAclPresence['children'])) $aclPresence->setChildren($this->createChildren($probablyAclPresence['children']));

            $aclPresences->put($aclPresence->getAnchor(), $aclPresence);
        }

        return $aclPresences;
    }

    /**
     * @param array $itemContent
     *
     * @return bool
     */
    public function checkStructure(array $itemContent): bool
    {
        $validator = Validator::make($itemContent, self::$rules);

        return !$validator->fails();
    }
}
