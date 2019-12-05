<?php

namespace Selene\Variabler\Providers;

use Selene\Contracts\Variabler\VariableProvider;

/**
 * Class ObjectPropertyProvider
 * @package Selene\Utils\Variabler\Providers
 */
class ObjectPropertyProvider implements VariableProvider
{

    /**
     * @param $object
     * @param $key
     *
     * @return mixed
     */
    public function replace($key, $object = null)
    {
        if (!is_object($object) || !isset($object->$key)) return $key;

        return $object->$key;
    }
}
