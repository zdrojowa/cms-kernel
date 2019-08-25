<?php

namespace Zdrojowa\CmsKernel\Tests\Propertiable;

use Zdrojowa\CmsKernel\Exceptions\PropertyBinder\PropertyCanNotPassValidationException;
use Zdrojowa\CmsKernel\Exceptions\PropertyBinder\PropertyIsRequiredException;
use Zdrojowa\CmsKernel\Exceptions\PropertyBinder\PropertyNameMustBeAStringException;
use Zdrojowa\CmsKernel\Tests\Helpers\ClassWithPropertiable;
use Zdrojowa\CmsKernel\Tests\TestCase;

class PropertiableTest extends TestCase
{

    private $class;

    public function setUp(): void
    {
        parent::setUp();

        $this->class = new ClassWithPropertiable();
    }

    public function testAddProperties()
    {
        $data = [
            'test' => 'test',
            'test_2' => 'test_2',
        ];

        $toBind = ['test', 'test_2'];

        $this->class->bindProperties($data, $toBind);

        $this->assertSame('test', $this->class->test);
        $this->assertSame('test_2', $this->class->test_2);
    }

    public function testPropertyNameMustBeAStringException()
    {
        $data = [];
        $toBind = [[]];

        $this->expectException(PropertyNameMustBeAStringException::class);

        $this->class->bindProperties($data, $toBind);
    }

    public function testPropertyIsRequiredException()
    {
        $data = [];
        $toBind = ['test'];

        $this->expectException(PropertyIsRequiredException::class);

        $this->class->bindProperties($data, $toBind, [], true);
    }

    public function testPropertyCanNotPassValidationException()
    {
        $data = [
            'test' => 'test',
        ];

        $toBind = ['test'];

        $rules = [
            'test' => 'email',
        ];

        $this->expectException(PropertyCanNotPassValidationException::class);

        $this->class->bindProperties($data, $toBind, $rules, true);
    }
}
