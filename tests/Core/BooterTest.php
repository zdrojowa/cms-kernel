<?php

namespace Selene\Tests\Core;

use Selene\Contracts\Booter\Booter;
use Selene\Support\Enums\Core\CoreModules;
use Selene\Tests\TestCase;

class BooterTest extends TestCase
{

    public function testBooterInstance()
    {
        $this->assertInstanceOf(Booter::class, $this->booter());
    }

    public function testIsCorrectlyBooted()
    {
        $this->assertFalse($this->booter()->hasError());
        $this->assertEmpty($this->booter()->getErrors());
        $this->assertTrue($this->booter()->allCoreModulesBooted());
        $this->assertTrue($this->booter()->isCoreModuleBooted(CoreModules::CORE()));
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
