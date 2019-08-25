<?php

namespace Zdrojowa\CmsKernel\Tests\Modules;

use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleConfigException;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleInstanceException;
use Zdrojowa\CmsKernel\Tests\Helpers\ExampleClass;
use Zdrojowa\CmsKernel\Tests\Helpers\TestValidModule\ValidModule;
use Zdrojowa\CmsKernel\Tests\TestCase;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

class ModuleManagerTest extends TestCase
{

    public function testInstance()
    {
        $this->assertInstanceOf(ModuleManagerInterface::class, $this->moduleManager());
    }

    public function testGetVersion()
    {
        $this->assertSame($this->moduleManager()->version, $this->moduleManager()->version());
    }

    public function testHasModuleMustReturnFalse()
    {
        $this->assertFalse($this->moduleManager()->has('Test'));
    }

    public function testAddModule()
    {
        $this->assertEmpty($this->moduleManager()->getModules());

        $this->moduleManager()->addModule(app(ValidModule::class));

        $this->assertNotEmpty($this->moduleManager()->getModules());

        $this->assertInstanceOf(ValidModule::class, $this->moduleManager()->getModule('ValidModule'));
    }

    public function testGetModule()
    {
        $this->assertNull($this->moduleManager()->getModule('Test'));
    }

    public function testFailedInitialize()
    {
        $this->app['config']->set(CoreEnum::CMS_CONFIG . '.' . CoreEnum::MODULES_SECTION, '');

        $this->expectException(ModuleConfigException::class);

        $this->moduleManager()->initialize();

        $this->app['config']->set(CoreEnum::CMS_CONFIG . '.' . CoreEnum::MODULES_SECTION, [ExampleClass::class]);

        $this->expectException(ModuleInstanceException::class);
    }

}
