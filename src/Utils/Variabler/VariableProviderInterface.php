<?php

namespace Zdrojowa\InvestmentCMS\Utils\Variabler;

/**
 * Interface VariableProviderInterface
 * @package Zdrojowa\InvestmentCMS\Utils\Variabler
 */
interface VariableProviderInterface
{

    /**
     * @param $object
     * @param $key
     *
     * @return mixed
     */
    public function replace($object, $key);
}
