<?php

namespace Zdrojowa\CmsKernel\Booter\Events;

use Zdrojowa\CmsKernel\Contracts\Booter\Booter;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class BooterRegisterEvent
 * @package Zdrojowa\CmsKernel\Booter\Events
 */
class BooterRegisterEvent extends CmsKernelEvent
{

    /**
     * @var Booter
     */
    public $booter;

    /**
     * BooterRegisterEvent constructor.
     *
     * @param Booter $booter
     */
    public function __construct(Booter $booter)
    {
        $this->booter = $booter;
    }
}
