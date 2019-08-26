<?php

namespace Selene\Tests\Core;

use Selene\Contracts\Core\Core;
use Selene\Support\Enums\Core\CoreModules;
use Selene\Tests\TestCase;

class CoreTest extends TestCase
{

    public function testCoreInstance()
    {
        $this->assertInstanceOf(Core::class, $this->core());
    }

    public function testGetVersion()
    {
        $this->assertSame($this->core()->version, $this->core()->getVersion());
    }

    public function testAclRepository()
    {
        $this->assertSame($this->core()->aclRepository(), $this->app->get(CoreModules::ACL_REPOSITORY));
    }

    public function testModuleManager()
    {
        $this->assertSame($this->core()->moduleManager(), $this->app->get(CoreModules::MODULE_MANAGER));
    }
}
