<?php

namespace Zdrojowa\CmsKernel\Tests\Core;

use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Tests\TestCase;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

class BooterTest extends TestCase
{

    public function testBooterInstance()
    {
        $this->assertInstanceOf(BooterInterface::class, $this->booter());
    }

    public function testIsCorrectlyBooted()
    {
        $this->assertFalse($this->booter()->hasError());
        $this->assertEmpty($this->booter()->getErrors());
        $this->assertTrue($this->booter()->allCoreModulesBooted());
        $this->assertTrue($this->booter()->isCoreModuleBooted(CoreModulesEnum::CORE()));
    }

    public function testAddErrors()
    {
        $error = 'Example error';

        $this->booter()->addError($error);

        $this->assertTrue($this->booter()->hasError());
        $this->assertNotEmpty($this->booter()->getErrors());
        $this->assertSame($this->booter()->getErrors()[0], $error);
    }

    public function testGetVersion()
    {
        $this->assertSame($this->booter()->version, $this->booter()->getVersion());
    }
}
