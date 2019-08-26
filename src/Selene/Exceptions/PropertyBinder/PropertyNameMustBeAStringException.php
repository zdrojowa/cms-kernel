<?php

namespace Selene\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;

/**
 * Class PropertyNameMustBeAStringException
 * @package Selene\Exceptions\PropertyBinder
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
