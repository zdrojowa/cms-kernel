<?php

namespace Selene\Core\Events;

use Selene\Contracts\Core\Core;
use Selene\Events\CmsKernelEvent;

/**
 * Class CoreBootedEvent
 * @package Selene\Core\Events
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
