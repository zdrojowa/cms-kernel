<?php

namespace Zdrojowa\CmsKernel\Exceptions\Acl;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class AclPresenceDataException
 * @package Zdrojowa\CmsKernel\Exceptions\Acl
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
        return "Bad data for acl presence";
    }
}
