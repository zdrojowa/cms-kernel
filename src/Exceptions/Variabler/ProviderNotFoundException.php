<?php

namespace Zdrojowa\CmsKernel\Exceptions\Variabler;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

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
