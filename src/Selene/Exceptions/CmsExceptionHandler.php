<?php

namespace Selene\Exceptions;

use Exception;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

class CmsExceptionHandler
{
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
        $this->debug = Config::get(Core::DEBUG);

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
