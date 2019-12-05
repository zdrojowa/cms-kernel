<?php

namespace Selene\Acl;

use Illuminate\Support\Collection;
use IteratorAggregate;
use JsonSerializable;
use Selene\Contracts\Acl\Presence\AclPresence as AclPresenceContract;
use Traversable;

/**
 * Class AclPresence
 * @package Selene\Acl
 */
class AclPresence implements AclPresenceContract, JsonSerializable, IteratorAggregate
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

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'data' => [
                'name' => $this->name,
                'anchor' => $this->anchor
            ],
            'children' => $this->children ? $this->children->toArray() : []
        ];
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new AclPresenceIterator([$this]);
    }
}
