<?php

namespace Zdrojowa\CmsKernel\Tests\Core;

use Zdrojowa\CmsKernel\Contracts\Variabler\VariablerInterface;
use Zdrojowa\CmsKernel\Exceptions\Variabler\ProviderInstanceException;
use Zdrojowa\CmsKernel\Exceptions\Variabler\ProviderNotFoundException;
use Zdrojowa\CmsKernel\Tests\Helpers\ExampleClass;
use Zdrojowa\CmsKernel\Tests\Propertiable\PropertiableTest;
use Zdrojowa\CmsKernel\Tests\TestCase;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
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

        $config->set(CoreEnum::CMS_CONFIG . '.' . CoreEnum::VARIABLER_PROVIDERS_SECTION, [
            'name' => ObjectNameProvider::class,
            'property' => ObjectPropertyProvider::class,
            'testInstance' => PropertiableTest::class,
        ]);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(VariablerInterface::class, $this->variabler());
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
