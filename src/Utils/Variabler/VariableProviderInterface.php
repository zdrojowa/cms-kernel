<?php

namespace Zdrojowa\CmsKernel\Utils\Variabler;

/**
 * Interface VariableProviderInterface
 * @package Zdrojowa\CmsKernel\Utils\Variabler
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
