<?php

namespace Selene\Acl\Exceptions;

use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;

/**
 * Class AclPresenceDataException
 * @package Selene\Acl\Exceptions
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
