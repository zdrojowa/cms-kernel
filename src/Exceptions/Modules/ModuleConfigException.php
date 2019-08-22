<?php

namespace Zdrojowa\CmsKernel\Exceptions\Modules;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

/**
 * Class ModuleConfigException
 * @package Zdrojowa\CmsKernel\Exceptions\Modules
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
        return CoreEnum::CORE_MODULES_SECTION.' section is invalid';
    }
}
