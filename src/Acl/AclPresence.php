<?php

namespace Zdrojowa\CmsKernel\Acl;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Acl\Presence\AclPresence as AclPresenceContract;

/**
 * Class AclPresence
 * @package Zdrojowa\CmsKernel\Acl
 */
class AclPresence implements AclPresenceContract
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
     * @param string $anchor
     * @param string $name
     * @param Collection|null $children
     */
    public function __construct(string $anchor, string $name, Collection $children = null)
    {
        $this->anchor = $anchor;
        $this->name = $name;
        $this->children = $children;
    }

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection|null
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        if ($this->children === null || $this->children->count() === 0) return false;

        return true;
    }
}
