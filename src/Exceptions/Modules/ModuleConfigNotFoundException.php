<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\Modules;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class ModuleConfigNotFoundException
 * @package Zdrojowa\InvestmentCMS\Exceptions\Modules
 */
class ModuleConfigNotFoundException extends InvestmentCMSException
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
        return $data[0]."'s config ".$data[1]." not found";
    }
}
