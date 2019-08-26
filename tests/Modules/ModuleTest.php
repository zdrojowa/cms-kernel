<?php

namespace Zdrojowa\CmsKernel\Tests\Modules;

use Zdrojowa\CmsKernel\Tests\Helpers\TestValidModule\ValidModule;
use Zdrojowa\CmsKernel\Tests\TestCase;

class ModuleTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->module = app(ValidModule::class);
        $this->module->loadConfig();
        $this->module->mapRoutes();
    }

    public function testGetName()
    {
        $this->assertSame('ValidModule', $this->module->getName());
    }

    public function testGetVersion()
    {
        $this->assertSame('0.0.1', $this->module->getVersion());
    }

    public function testGetRoutePrefix()
    {
        $this->assertSame('ValidModule', $this->module->getRoutePrefix());
    }

    public function testGetAclAnchor()
    {
        $this->assertSame('test', $this->module->getAclAnchor());
    }

    public function testGetAclName()
    {
        $this->assertSame('ValidModule', $this->module->getAclName());
    }

    public function testGetRoutes()
    {
        $route = [
            "test" => [
                "path" => "/test/test/test/test",
                "controller" => "Zdrojowa\CmsKernel\Tests\Helpers\TestValidModule\TestController@test",
            ],
        ];

        $this->assertNotEmpty($this->module->getRoutes());
        $this->assertSame($this->module->getRoutes(), $route);
    }

    public function testRouteMapping()
    {
        foreach ($this->module->getRoutes() as $route) {
            $response = $this->get($route['path']);

            if ((int)$response->status() !== 200) {
                $this->assertTrue(false);
            } else {
                $this->assertTrue(true);
            }
        }
    }

}
