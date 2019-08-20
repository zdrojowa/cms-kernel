<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder;

use Psr\Log\LogLevel;
use Throwable;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class PropertyCanNotPassValidationException
 * @package Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder
 */
class PropertyCanNotPassValidationException extends InvestmentCMSException
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
    public function formatMessage($data): string
    {
        return "Property " . $data[0] . " can not pass validation rule: " . $data[1];
    }
}
