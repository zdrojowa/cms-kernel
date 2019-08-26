<?php

namespace Selene\Tests\Core;

use Selene\Contracts\Variabler\Variabler;
use Selene\Support\Enums\Core\Core;
use Selene\Tests\Helpers\ExampleClass;
use Selene\Tests\Propertiable\PropertiableTest;
use Selene\Tests\TestCase;
use Selene\Variabler\Exceptions\ProviderInstanceException;
use Selene\Variabler\Exceptions\ProviderNotFoundException;
use Selene\Variabler\Providers\ObjectNameProvider;
use Selene\Variabler\Providers\ObjectPropertyProvider;

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
