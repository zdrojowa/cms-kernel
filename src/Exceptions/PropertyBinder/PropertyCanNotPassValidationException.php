<?php

namespace Zdrojowa\CmsKernel\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Throwable;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class PropertyCanNotPassValidationException
 * @package Zdrojowa\CmsKernel\Exceptions\PropertyBinder
 */
class PropertyCanNotPassValidationException extends CmsKernelException
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
    public function formatMessage($data): string
    {
        return "Property " . $data[0] . " can not pass validation rule: " . $data[1];
    }
}
