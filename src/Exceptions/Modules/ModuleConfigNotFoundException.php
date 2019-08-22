<?php

namespace Zdrojowa\CmsKernel\Exceptions\Modules;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class ModuleConfigNotFoundException
 * @package Zdrojowa\CmsKernel\Exceptions\Modules
 */
class ModuleConfigNotFoundException extends CmsKernelException
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
        return $data[0]."'s config ".$data[1]." not found";
    }
}
