<?php

namespace Zdrojowa\CmsKernel\Contracts\Acl;

use Illuminate\Support\Collection;
use Validator;
use Zdrojowa\CmsKernel\Exceptions\Acl\AclPresenceDataException;

/**
 * Class AclPresence
 * @package Zdrojowa\CmsKernel\Contracts\Acl
 */
class AclPresence
{

    /**
     * @var string
     */
    private $anchor;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Collection
     */
    private $children;

    /**
     * @var array
     */
    protected static $rules = [
        'name' => 'string',
        'children' => 'sometimes|array',
    ];

    /**
     * AclPresence constructor.
     *
     * @param $anchor
     * @param $name
     * @param Collection|null $children
     */
    public function __construct(string $anchor, string $name, Collection $children = null)
    {
        $this->anchor = $anchor;
        $this->name = $name;
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @return mixed
     */
    private function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;
    }

    /**
     * @param array $itemContent
     *
     * @return bool
     */
    public static function checkStructure(array $itemContent): bool
    {
        $validator = Validator::make($itemContent, self::$rules);

        return !$validator->fails();
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public static function checkDataStructure($data): bool
    {
        return is_array($data);
    }

    /**
     * @param $data
     *
     * @return Collection|null
     * @throws AclPresenceDataException
     */
    public static function createPresenceFromData($data): ?Collection
    {
        if (!self::checkDataStructure($data)) {
            throw new AclPresenceDataException('');
        }

        $aclPresences = new Collection();

        foreach ($data as $anchor => $probablyAclPresence) {
            if (!AclPresence::checkStructure($probablyAclPresence ?? [])) {
                throw new AclPresenceDataException('');
            }

            $aclPresence = new self($anchor, $probablyAclPresence['name']);

            if (isset($probablyAclPresence['children'])) $aclPresence->setChildren(self::createPresenceFromData($probablyAclPresence['children']));

            $aclPresences->put($aclPresence->getAnchor(), $aclPresence);
        }

        return $aclPresences;
    }

}
