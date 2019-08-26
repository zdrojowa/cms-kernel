<?php

namespace Zdrojowa\CmsKernel\Core\Events;

use Zdrojowa\CmsKernel\Contracts\Core\Core;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class CoreRegisterEvent
 * @package Zdrojowa\CmsKernel\Core\Events
 */
class CoreRegisterEvent extends CmsKernelEvent
{

    /**
     * @var Core
     */
    public $core;

    /**
     * CoreRegisterEvent constructor.
     *
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        $this->core = $core;
    }
}
