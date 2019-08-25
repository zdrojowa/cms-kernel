<?php

namespace Zdrojowa\CmsKernel\Tests\Modules;

use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Modules\Exceptions\ModuleConfigException;
use Zdrojowa\CmsKernel\Modules\Exceptions\ModuleInstanceException;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;
use Zdrojowa\CmsKernel\Tests\Helpers\ExampleClass;
use Zdrojowa\CmsKernel\Tests\Helpers\TestValidModule\ValidModule;
use Zdrojowa\CmsKernel\Tests\TestCase;

class ModuleManagerTest extends TestCase
{

    public function testInstance()
    {
        $this->assertInstanceOf(ModuleManager::class, $this->moduleManager());
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
        $this->app['config']->set(Core::CONFIG . '.' . Core::MODULES, '');

        $this->expectException(ModuleConfigException::class);

        $this->moduleManager()->initialize();

        $this->app['config']->set(Core::CONFIG . '.' . Core::MODULES, [ExampleClass::class]);

        $this->expectException(ModuleInstanceException::class);
    }

}
