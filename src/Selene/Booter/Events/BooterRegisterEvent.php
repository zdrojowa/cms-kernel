<?php

namespace Selene\Booter\Events;

use Selene\Contracts\Booter\Booter;
use Selene\Events\CmsKernelEvent;

/**
 * Class BooterRegisterEvent
 * @package Selene\Booter\Events
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
