<?php

namespace Zdrojowa\CmsKernel\Exceptions;

use Exception;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

class CmsExceptionHandler
{
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
        $this->debug = ConfigUtils::coreConfig(CoreEnum::CMS_DEBUG);

        $this->throw();
    }

    public function throw()
    {
        if ($this->debug) {
            throw new $this->exception($this->exception->getMessage());
        }

        report($this->exception);
    }

    public static function handle(Exception $exception)
    {
        return new static($exception);
    }
}
