<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class PropertyIsRequiredException
 * @package Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder
 */
class PropertyIsRequiredException extends InvestmentCMSException
{
    /**
     * @var string
     */
    public $level = LogLevel::ERROR;

    /**
     * @param $property
     *
     * @return string
     */
    public function formatMessage($property): string
    {
        return "Property $property is required";
    }

}
