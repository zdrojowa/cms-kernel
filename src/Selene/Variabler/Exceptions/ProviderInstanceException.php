<?php

namespace Selene\Variabler\Exceptions;

use Psr\Log\LogLevel;
use Selene\Contracts\Variabler\VariableProvider;
use Selene\Exceptions\CmsKernelException;

/**
 * Class ProviderInstanceException
 * @package Selene\Variabler\Exceptions\Variabler
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
