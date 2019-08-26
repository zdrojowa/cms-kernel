<?php

namespace Zdrojowa\CmsKernel\Tests\Acl;

use Zdrojowa\CmsKernel\Acl\AclPresence;
use Zdrojowa\CmsKernel\Tests\TestCase;

class AclPresenceTest extends TestCase
{

    private $presence;
    private $childPresence;
    private $children;

    public function setUp(): void
    {
        parent::setUp();

        $this->presence = new AclPresence('test', 'AclTest');
        $this->childPresence = new AclPresence('child', 'Child');
        $this->children = collect(['child' => $this->childPresence]);
    }

    public function testGetEmptyChildren()
    {
        $this->assertNull($this->presence->getChildren());
        $this->assertEmpty($this->presence->getChildren());
    }

    public function testAnchor()
    {
        $this->assertSame('test', $this->presence->getAnchor());
    }

    public function testGetName()
    {
        $this->assertSame('AclTest', $this->presence->getName());
    }

    public function testHasEmptyChildren()
    {
        $this->assertFalse($this->presence->hasChildren());
    }

    public function testSetChildren()
    {
        $this->presence->setChildren($this->children);

        $this->assertNotEmpty($this->presence->getChildren());
    }
}
