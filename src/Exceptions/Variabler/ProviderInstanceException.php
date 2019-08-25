<?php

namespace Zdrojowa\CmsKernel\Exceptions\Variabler;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Contracts\Variabler\VariableProviderInterface;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

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
        return "Class " . $data . " must be an instance of " . VariableProviderInterface::class;
    }
}
