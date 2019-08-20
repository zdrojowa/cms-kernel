<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\Acl;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class AclPresenceDataException
 * @package Zdrojowa\InvestmentCMS\Exceptions\Acl
 */
class AclPresenceDataException extends InvestmentCMSException
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
