<?php

namespace Zdrojowa\CmsKernel\Contracts\Variabler;

/**
 * Interface VariableProvider
 * @package Zdrojowa\CmsKernel\Contracts\Variabler
 */
interface VariableProvider
{
    /**
     * @param $key
     * @param null $object
     *
     * @return mixed
     */
    public function replace($key, $object = null);
}
