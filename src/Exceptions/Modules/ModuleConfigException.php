<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\Modules;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;

/**
 * Class ModuleConfigException
 * @package Zdrojowa\InvestmentCMS\Exceptions\Modules
 */
class ModuleConfigException extends InvestmentCMSException
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
        return CoreEnum::CORE_MODULES_SECTION.' section is invalid';
    }
}
