<?php

namespace Zdrojowa\CmsKernel\Contracts\Variabler;

/**
 * Interface VariablerInterface
 * @package Zdrojowa\CmsKernel\Contracts\Variabler
 */
interface VariablerInterface
{
    /**
     * @param $data
     * @param object|null $object
     *
     * @return mixed
     */
    public function make($data, object $object = null);
}
