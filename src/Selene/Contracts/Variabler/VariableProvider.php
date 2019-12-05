<?php

namespace Selene\Contracts\Variabler;

/**
 * Interface VariableProvider
 * @package Selene\Contracts\Variabler
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
