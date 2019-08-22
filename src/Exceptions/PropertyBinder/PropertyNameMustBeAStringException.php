<?php

namespace Zdrojowa\CmsKernel\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class PropertyNameMustBeAStringException
 * @package Zdrojowa\CmsKernel\Exceptions\PropertyBinder
 */
class PropertyNameMustBeAStringException extends CmsKernelException
{
    /**
     * @var string
     */
    public $level = LogLevel::ERROR;

    /**
     * @param $data
     *
     * @return string
     */
    function formatMessage($data): string
    {
        return "Property name must be a string";
    }
}
