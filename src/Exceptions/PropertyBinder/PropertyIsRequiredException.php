<?php

namespace Zdrojowa\CmsKernel\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class PropertyIsRequiredException
 * @package Zdrojowa\CmsKernel\Exceptions\PropertyBinder
 */
class PropertyIsRequiredException extends CmsKernelException
{
    /**
     * @var string
     */
    public $level = LogLevel::ERROR;

    /**
     * @param $property
     *
     * @return string
     */
    public function formatMessage($property): string
    {
        return "Property $property is required";
    }

}
