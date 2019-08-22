<?php

namespace Zdrojowa\CmsKernel\Exceptions\Modules;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class ModuleInstanceException
 * @package Zdrojowa\CmsKernel\Exceptions\Modules
 */
class ModuleInstanceException extends CmsKernelException
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
