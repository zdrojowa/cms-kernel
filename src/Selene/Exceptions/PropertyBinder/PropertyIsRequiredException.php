<?php

namespace Selene\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;

/**
 * Class PropertyIsRequiredException
 * @package Selene\Exceptions\PropertyBinder
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
        return get_class($property[0]).": ".$property[1]." is required";
    }

}
