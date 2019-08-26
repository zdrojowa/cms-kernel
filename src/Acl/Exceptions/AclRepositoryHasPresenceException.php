<?php

namespace Zdrojowa\CmsKernel\Acl\Exceptions;


use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class AclRepositoryHasPresenceException
 * @package Zdrojowa\CmsKernel\Acl\Exceptions
 */
class AclRepositoryHasPresenceException extends CmsKernelException
{
    /**
     * @var string
     */
    public $level = LogLevel::CRITICAL;

    /**
     * @param $data
     * @return string
     */
    function formatMessage($data): string
    {
        return 'AclPresence of module $data exists';
    }
}
