<?php

namespace Zdrojowa\CmsKernel\Variabler\Exceptions;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class ProviderNotFoundException
 * @package Zdrojowa\CmsKernel\Variabler\Exceptions\Variabler
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
