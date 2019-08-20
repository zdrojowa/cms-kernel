<?php


namespace Zdrojowa\InvestmentCMS\Exceptions\Acl;


use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class AclRepositoryHasPresenceException
 * @package Zdrojowa\InvestmentCMS\Exceptions\Acl
 */
class AclRepositoryHasPresenceException extends InvestmentCMSException
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
