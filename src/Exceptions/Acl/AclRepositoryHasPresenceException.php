<?php


namespace Zdrojowa\CmsKernel\Exceptions\Acl;


use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class AclRepositoryHasPresenceException
 * @package Zdrojowa\CmsKernel\Exceptions\Acl
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
