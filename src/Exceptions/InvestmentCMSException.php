<?php

namespace Zdrojowa\InvestmentCMS\Exceptions;

use Exception;
use Psr\Log\LogLevel;
use Throwable;
use Zdrojowa\InvestmentCMS\Facades\Core;

/**
 * Class InvestmentCMSException
 * @package Zdrojowa\InvestmentCMS\Exceptions
 */
abstract class InvestmentCMSException extends Exception
{
    /**
     * InvestmentCMSException constructor.
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
        if(!isset($this->level)) {
            $this->level = LogLevel::ERROR;
        }

        Core::log($this->level, $this->getMessage(), ['Exception' => get_class($this), 'File' => '`'.$this->getFile().'`', 'Line' => $this->getLine()]);
    }

    /**
     * @param $data
     *
     * @return string
     */
    abstract function formatMessage($data): string;
}
