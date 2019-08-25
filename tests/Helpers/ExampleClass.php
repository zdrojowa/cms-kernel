<?php

namespace Zdrojowa\CmsKernel\Tests\Helpers;

/**
 * Class ExampleClass
 * @package Zdrojowa\CmsKernel\Tests\Helpers
 */
class ExampleClass
{

    /**
     * @var string
     */
    public $name;

    /**
     * ExampleClass constructor.
     *
     * @param string $name
     * @param $value
     */
    public function __construct(string $name, string $stringValue, array $arrayValue)
    {
        $this->name = $name;
        $this->stringValue = $stringValue;
        $this->arrayValue = $arrayValue;
    }
}
