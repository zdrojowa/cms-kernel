<?php

namespace Selene\Tests\Helpers;

/**
 * Class ExampleClass
 * @package Selene\Tests\Helpers
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
     * @param string $stringValue
     * @param array $arrayValue
     */
    public function __construct(string $name, string $stringValue, array $arrayValue)
    {
        $this->name = $name;
        $this->stringValue = $stringValue;
        $this->arrayValue = $arrayValue;
    }
}
