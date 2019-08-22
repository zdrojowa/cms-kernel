<?php

namespace Zdrojowa\CmsKernel\Events\Core;

use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class CoreRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Core
 */
class CoreRegisterEvent extends CmsKernelEvent
{

    /**
     * @var CoreInterface
     */
    public $core;

    /**
     * CoreRegisterEvent constructor.
     *
     * @param CoreInterface $core
     */
    public function __construct(CoreInterface $core)
    {
        $this->core = $core;
    }
}
