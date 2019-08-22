<?php

namespace Zdrojowa\CmsKernel\Exceptions\Booter;

use Psr\Log\LogLevel;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;

/**
 * Class InvalidCoreModuleDeclarationException
 * @package Zdrojowa\CmsKernel\Exceptions\Booter
 */
class InvalidCoreModuleDeclarationException extends CmsKernelException
{
    /**
     * @var string
     */
    public $level = LogLevel::CRITICAL;

    /**
     * @param $class
     *
     * @return string
     */
    public function formatMessage($class): string
    {
        return "Core module $class declared in config is invalid";
    }
}
