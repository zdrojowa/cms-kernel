<?php

namespace Zdrojowa\CmsKernel\Tests\Acl;

use Zdrojowa\CmsKernel\Acl\AclPresence;
use Zdrojowa\CmsKernel\Tests\TestCase;

class AclRepositoryTest extends TestCase
{

    private $childPresence;
    private $children;
    private $presence;

    public function setUp(): void
    {
        parent::setUp();

        $this->childPresence = new AclPresence('child', 'Child');
        $this->children = collect(['child' => $this->childPresence]);
        $this->presence = new AclPresence('test', 'AclTest', $this->children);
    }

    public function testEmptyPresences()
    {
        $this->assertEmpty($this->aclRepository()->getPresences());
    }

    public function testAddPresence()
    {
        $this->assertFalse($this->aclRepository()->hasMainPresence('AclTest'));
        $this->aclRepository()->addPresence($this->presence);

        $this->assertTrue($this->aclRepository()->hasMainPresence('AclTest'));
        $this->assertSame($this->childPresence, $this->aclRepository()->get('AclTest.child'));
        $this->assertSame($this->presence, $this->aclRepository()->getMainPresence('AclTest'));
    }
}
