<?php

namespace Zdrojowa\CmsKernel\Menu;

use Illuminate\Support\Collection;
use Validator;

/**
 * Class MenuPresence
 * @package Zdrojowa\CmsKernel\Menu
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
     * @var string
     */
    private $route;
    /**
     * @var string
     */
    private $icon;
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
        'route' => 'sometimes|string',
        'children' => 'sometimes|array',
    ];

    /**
     * AclPresence constructor.
     *
     * @param string $anchor
     * @param string $name
     * @param string $route
     * @param string|null $icon
     * @param Collection|null $children
     */
    public function __construct(string $anchor, string $name, string $route = null, string $icon = null, Collection $children = null)
    {
        $this->anchor = $anchor;
        $this->name = $name;
        $this->route = $route;
        $this->icon = $route;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
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
     * @return bool
     */
    public function hasChildren(): bool
    {
        if ($this->children !== null && count($this->children) > 0) return true;

        return false;
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

        $menuPresences = new Collection();

        foreach ($data as $anchor => $probablyMenuPresence) {

            //dd($anchor, $probablyMenuPresence);
            if (!self::checkStructure($probablyMenuPresence)) {
                continue;

                //TODO: Log bad structure for menu data
            }

            $menuPresence = new self($anchor, $probablyMenuPresence['name']);

            if (isset($probablyMenuPresence['children'])) $menuPresence->setChildren(self::createPresenceFromData($probablyMenuPresence['children']));

            $menuPresences->put($menuPresence->getAnchor(), $menuPresence);
        }

        return $menuPresences;
    }
}
