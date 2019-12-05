<?php

namespace Selene\Acl\Exceptions;


use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;

/**
 * Class AclRepositoryHasPresenceException
 * @package Selene\Acl\Exceptions
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
