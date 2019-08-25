<?php

namespace Zdrojowa\CmsKernel\Core\Events;

use Zdrojowa\CmsKernel\Contracts\Core\Core;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class CoreBootedEvent
 * @package Zdrojowa\CmsKernel\Core\Events
 */
class CoreBootedEvent extends CmsKernelEvent
{

    /**
     * @var Core
     */
    public $core;

    /**
     * CoreBootedEvent constructor.
     *
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        $this->core = $core;
    }

}
