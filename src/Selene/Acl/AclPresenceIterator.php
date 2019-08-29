<?php

namespace Selene\Acl;

use RecursiveArrayIterator;

class AclPresenceIterator extends RecursiveArrayIterator
{

    public function hasChildren()
    {
        return $this->current()->hasChildren();
    }

    public function getChildren()
    {
        return new AclPresenceIterator($this->current()->getChildren()->toArray());
    }
}
