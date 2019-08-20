<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class PropertyNameMustBeAStringException
 * @package Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder
 */
class PropertyNameMustBeAStringException extends InvestmentCMSException
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
        return "Property name must be a string";
    }
}
