<?php

namespace Selene\Modules\Exceptions;

use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;

/**
 * Class ModuleConfigNotFoundException
 * @package Selene\Modules\Exceptions
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
        return $data[0]."'s config file ".$data[1]." not found";
    }
}
