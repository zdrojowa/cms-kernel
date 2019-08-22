<?php


namespace Zdrojowa\CmsKernel\Events\Core;


use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class CoreBootedEvent
 * @package Zdrojowa\CmsKernel\Events\Core
 */
class CoreBootedEvent extends CmsKernelEvent
{

    /**
     * @var CoreInterface
     */
    public $core;

    /**
     * CoreBootedEvent constructor.
     * @param CoreInterface $core
     */
    public function __construct(CoreInterface $core)
    {
        $this->core = $core;
    }

}
