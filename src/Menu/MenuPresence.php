<?php

namespace Zdrojowa\InvestmentCMS\Menu;

use Illuminate\Support\Collection;
use Validator;

/**
 * Class MenuPresence
 * @package Zdrojowa\InvestmentCMS\Menu
 */
class MenuPresence
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
        'name' => 'string|required',
        'permission' => 'required',
        'type' => 'in:GROUP,GET,POST',
        'children' => 'sometimes|array',
    ];


    /**
     * AclPresence constructor.
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
     * @return bool
     */
    public static function checkStructure(array $itemContent): bool
    {
        $validator = Validator::make($itemContent, self::$rules);

        return !$validator->fails();
    }

    /**
     * @param $data
     * @return bool
     */
    public static function checkDataStructure($data): bool
    {
        return is_array($data);
    }

    /**
     * @param $data
     * @return Collection|null
     */
    public static function createPresenceFromData($data): ?Collection
    {
        if (!self::checkDataStructure($data)) {
            //TODO: Log bad structure for menu data
            return null;
        }

        $menuPresence = new Collection();

        foreach ($data as $anchor => $probablyMenuPresence) {

            //dd($anchor, $probablyMenuPresence);
            if (!self::checkStructure($probablyMenuPresence)) {
                continue;

                //TODO: Log bad structure for menu data
            }

            $aclPresence = new self($anchor, $probablyMenuPresence['name']);

            if (isset($probablyMenuPresence['children'])) $aclPresence->setChildren(self::createPresenceFromData($probablyMenuPresence['children']));

            $menuPresence->put($aclPresence->getAnchor(), $aclPresence);
        }

        return $menuPresence;
    }
}
