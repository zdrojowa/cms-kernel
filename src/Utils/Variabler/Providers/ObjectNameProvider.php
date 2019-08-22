<?php

namespace Zdrojowa\CmsKernel\Utils\Variabler\Providers;

use ReflectionClass;
use stdClass;
use Zdrojowa\CmsKernel\Utils\Variabler\VariableProviderInterface;

/**
 * Class ObjectNameProvider
 * @package Zdrojowa\CmsKernel\Utils\Variabler\Providers
 */
class ObjectNameProvider implements VariableProviderInterface
{

    /**
     * @param $object
     * @param $key
     *
     * @return mixed
     */
    public function replace($object, $key)
    {
        if(!is_object($object)) return $key;

        try {
            $reflection = $object;

            if(!$reflection instanceof  ReflectionClass) {
                $reflection = new ReflectionClass($object);
            }

            return $reflection->getShortName();
        } catch (\ReflectionException $e) {
            report($e);
            return $key;
        }
    }
}
