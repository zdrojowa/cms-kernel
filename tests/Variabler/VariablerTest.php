<?php

namespace Zdrojowa\CmsKernel\Tests\Core;

use Zdrojowa\CmsKernel\Contracts\Variabler\Variabler;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;
use Zdrojowa\CmsKernel\Tests\Helpers\ExampleClass;
use Zdrojowa\CmsKernel\Tests\Propertiable\PropertiableTest;
use Zdrojowa\CmsKernel\Tests\TestCase;
use Zdrojowa\CmsKernel\Variabler\Exceptions\ProviderInstanceException;
use Zdrojowa\CmsKernel\Variabler\Exceptions\ProviderNotFoundException;
use Zdrojowa\CmsKernel\Variabler\Providers\ObjectNameProvider;
use Zdrojowa\CmsKernel\Variabler\Providers\ObjectPropertyProvider;

class VariablerTest extends TestCase
{

    /**
     * @var ExampleClass
     */
    private $class;

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new ExampleClass('test', '__name__', ['test' => '{stringValue}']);

        $config = $this->app['config'];

        $config->set(Core::CONFIG . '.' . Core::VARIABLER_PROVIDERS, [
            'name' => ObjectNameProvider::class,
            'property' => ObjectPropertyProvider::class,
            'testInstance' => PropertiableTest::class,
        ]);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Variabler::class, $this->variabler());
    }

    public function testClassNameVariable()
    {
        $this->assertSame('ExampleClass', $this->variabler()->make($this->class->stringValue, $this->class));
    }

    public function testPropertyVariable()
    {
        $this->assertSame('__name__', $this->variabler()->make($this->class->arrayValue, $this->class)['test']);
    }

    public function testProviderNotFoundException()
    {
        $this->expectException(ProviderNotFoundException::class);

        $this->variabler()->test();
    }

    public function testProviderInstanceException()
    {
        $this->expectException(ProviderInstanceException::class);

        $this->variabler()->testInstance('test');
    }
}
