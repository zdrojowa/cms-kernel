<?php

namespace Selene\Contracts\Acl\Presence;

use Illuminate\Support\Collection;

/**
 * Interface AclPresence
 * @package Selene\Contracts\Acl\Presence
 */
interface AclPresence
{
    /**
     * AclPresenceInterface constructor.
     *
     * @param string $anchor
     * @param string $name
     * @param Collection|null $children
     */
    public function __construct(string $anchor, string $name, Collection $children = null);

    /**
     * @return Collection|null
     */
    public function getChildren(): ?Collection;

    /**
     * @param Collection $children
     *
     * @return mixed
     */
    public function setChildren(Collection $children);

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return mixed
     */
    public function getAnchor();

    /**
     * @return mixed
     */
    public function getName();
}
