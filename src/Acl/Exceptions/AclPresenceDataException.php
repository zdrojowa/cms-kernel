<?php

namespace Zdrojowa\CmsKernel\Acl\Exceptions;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class AclPresenceDataException
 * @package Zdrojowa\CmsKernel\Acl\Exceptions
 */
class AclPresenceDataException extends CmsKernelException
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
        return "Bad data for ".$data[0]."'s' acl presence";
    }
}
