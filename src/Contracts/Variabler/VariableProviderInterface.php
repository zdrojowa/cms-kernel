<?php

namespace Zdrojowa\CmsKernel\Contracts\Variabler;

/**
 * Interface VariableProviderInterface
 * @package Zdrojowa\CmsKernel\Contracts\Variabler
 */
interface VariableProviderInterface
{
    /**
     * @param $key
     * @param null $object
     *
     * @return mixed
     */
    public function replace($key, $object = null);
}
