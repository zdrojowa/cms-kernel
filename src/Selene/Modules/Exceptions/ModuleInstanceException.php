<?php

namespace Selene\Modules\Exceptions;

use Psr\Log\LogLevel;
use Selene\Contracts\Modules\Module;
use Selene\Exceptions\CmsKernelException;

/**
 * Class ModuleInstanceException
 * @package Selene\Modules\Exceptions
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
        return "Class " . $data . " must be an instance of " . Module::class;
    }
}
