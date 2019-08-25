<?php

namespace Zdrojowa\CmsKernel\Tests\Core;

use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Tests\TestCase;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

class CoreTest extends TestCase
{

    public function testCoreInstance()
    {
        $this->assertInstanceOf(CoreInterface::class, $this->core());
    }

    public function testGetVersion()
    {
        $this->assertSame($this->core()->version, $this->core()->getVersion());
    }

    public function testAclRepository()
    {
        $this->assertSame($this->core()->aclRepository(), $this->app->get(CoreModulesEnum::ACL_REPOSITORY));
    }

    public function testModuleManager()
    {
        $this->assertSame($this->core()->moduleManager(), $this->app->get(CoreModulesEnum::MODULE_MANAGER));
    }
}
