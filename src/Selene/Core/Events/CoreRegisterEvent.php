<?php

namespace Selene\Core\Events;

use Selene\Contracts\Core\Core;
use Selene\Events\CmsKernelEvent;

/**
 * Class CoreRegisterEvent
 * @package Selene\Core\Events
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
