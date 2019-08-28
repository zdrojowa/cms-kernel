<?php

namespace Selene\Modules\Exceptions;

use Psr\Log\LogLevel;
use Selene\Exceptions\CmsKernelException;
use Selene\Support\Enums\Core\Core;

/**
 * Class ModuleConfigException
 * @package Selene\Modules\Exceptions\Modules
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
