<?php

namespace Zdrojowa\InvestmentCMS\Utils\Variabler\Providers;

use Zdrojowa\InvestmentCMS\Utils\Variabler\VariableProviderInterface;

/**
 * Class ObjectPropertyProvider
 * @package Zdrojowa\InvestmentCMS\Utils\Variabler\Providers
 */
class ObjectPropertyProvider implements VariableProviderInterface
{

    /**
     * @param $object
     * @param $key
     *
     * @return mixed
     */
    public function replace($object, $key)
    {
        if (!is_object($object) || !isset($object->$key)) return $key;

        return $object->$key;
    }
}
