<?php

namespace Zdrojowa\CmsKernel\Utils\Variabler\Providers;

use Zdrojowa\CmsKernel\Contracts\Variabler\VariableProviderInterface;

/**
 * Class ObjectPropertyProvider
 * @package Zdrojowa\CmsKernel\Utils\Variabler\Providers
 */
class ObjectPropertyProvider implements VariableProviderInterface
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
