<?php

namespace Zdrojowa\InvestmentCMS\Exceptions\Modules;

use Psr\Log\LogLevel;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Exceptions\InvestmentCMSException;

/**
 * Class ModuleInstanceException
 * @package Zdrojowa\InvestmentCMS\Exceptions\Modules
 */
class ModuleInstanceException extends InvestmentCMSException
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
        return "Class $data must be an instance of ".Module::class;
    }
}
