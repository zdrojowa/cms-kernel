<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\Booter;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class InvalidCoreModuleDeclarationException
 * @package Zdrojowa\InvestmentCMS\Exceptions\Booter
 */
class InvalidCoreModuleDeclarationException extends InvestmentCMSException
{
    /**
     * @var string
     */
    public $level = LogLevel::CRITICAL;

    /**
     * @param $class
     *
     * @return string
     */
    public function formatMessage($class): string
    {
        return "Core module $class declared in config is invalid";
    }
}
