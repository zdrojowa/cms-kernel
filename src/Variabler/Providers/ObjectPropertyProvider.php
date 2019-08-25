<?php

namespace Zdrojowa\CmsKernel\Variabler\Providers;

use Zdrojowa\CmsKernel\Contracts\Variabler\VariableProvider;

/**
 * Class ObjectPropertyProvider
 * @package Zdrojowa\CmsKernel\Utils\Variabler\Providers
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
