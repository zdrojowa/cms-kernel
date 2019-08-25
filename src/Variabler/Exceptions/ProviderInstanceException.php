<?php

namespace Zdrojowa\CmsKernel\Variabler\Exceptions;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Contracts\Variabler\VariableProvider;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class ProviderInstanceException
 * @package Zdrojowa\CmsKernel\Variabler\Exceptions\Variabler
 */
class ProviderInstanceException extends CmsKernelException
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
        return "Class " . $data . " must be an instance of " . VariableProvider::class;
    }
}
