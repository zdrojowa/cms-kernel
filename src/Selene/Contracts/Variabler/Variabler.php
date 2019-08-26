<?php

namespace Selene\Contracts\Variabler;

/**
 * Interface VariablerInterface
 * @package Selene\Contracts\Variabler
 */
interface Variabler
{
    /**
     * @param $data
     * @param object|null $object
     *
     * @return mixed
     */
    public function make($data, object $object = null);
}
