<?php

namespace Zdrojowa\CmsKernel\Modules\Exceptions;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;

/**
 * Class ModuleConfigException
 * @package Zdrojowa\CmsKernel\Modules\Exceptions\Modules
 */
class ModuleConfigException extends CmsKernelException
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
        return Core::CORE_MODULES . ' section is invalid';
    }
}
