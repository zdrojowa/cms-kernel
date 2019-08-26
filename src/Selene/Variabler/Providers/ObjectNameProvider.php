<?php

namespace Selene\Variabler\Providers;

use ReflectionClass;
use ReflectionException;
use Selene\Contracts\Variabler\VariableProvider;
use Selene\Exceptions\CmsExceptionHandler;

/**
 * Class ObjectNameProvider
 * @package Selene\Utils\Variabler\Providers
 */
class ObjectNameProvider implements VariableProvider
{

    /**
     * @param $object
     * @param $key
     *
     * @return mixed
     */
    public function replace($key, $object = null)
    {
        if (!is_object($object)) return $key;

        try {
            $reflection = $object;

            if (!$reflection instanceof ReflectionClass) {
                $reflection = new ReflectionClass($object);
            }

            return $reflection->getShortName();
        } catch (ReflectionException $e) {
            CmsExceptionHandler::handle($e);

            return $key;
        }
    }
}
