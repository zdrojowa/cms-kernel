<?php

namespace Zdrojowa\CmsKernel\Factories\Acl;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Acl\AclPresence;
use Zdrojowa\CmsKernel\Contracts\Factories\AclPresenceFactory;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Exceptions\Acl\AclPresenceDataException;
use Zdrojowa\CmsKernel\Contracts\Acl\AclPresenceInterface;
use Illuminate\Support\Facades\Validator;

/**
 * Class DataArrayAclPresenceFactory
 * @package Zdrojowa\CmsKernel\Factories\Acl
 */
class DataArrayAclPresenceFactory implements AclPresenceFactory
{

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
     * @param ModuleInterface $module
     */
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }

    /**
     * @return AclPresenceInterface
     * @throws AclPresenceDataException
     */
    public function create(): AclPresenceInterface
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
