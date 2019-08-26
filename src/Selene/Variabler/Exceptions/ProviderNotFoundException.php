<?php

namespace Selene\Variabler\Exceptions;

use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;

/**
 * Class ProviderNotFoundException
 * @package Selene\Variabler\Exceptions\Variabler
 */
class ProviderNotFoundException extends CmsKernelException
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
        return "Provider " . $data . " not found";
    }
}
