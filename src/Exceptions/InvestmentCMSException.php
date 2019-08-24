<?php

namespace Zdrojowa\CmsKernel\Exceptions;

use Exception;
use Psr\Log\LogLevel;
use Throwable;
use Zdrojowa\CmsKernel\Facades\Core;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class CmsKernelException
 * @package Zdrojowa\CmsKernel\Exceptions
 */
abstract class CmsKernelException extends Exception
{
    /**
     * CmsKernelException constructor.
     *
     * @param string $data
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($data = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->formatMessage($data), $code, $previous);
    }

    /**
     *
     */
    public function report()
    {
        if (!isset($this->level)) {
            $this->level = LogLevel::ERROR;
        }

        app(CoreModulesEnum::BOOTER)->addError($this->getMessage());

        Core::log($this->level, $this->getMessage(), [
            'Exception' => get_class($this),
            'File' => '`' . $this->getFile() . '`',
            'Line' => $this->getLine(),
        ]);
    }

    /**
     * @param $data
     *
     * @return string
     */
    abstract function formatMessage($data): string;
}
