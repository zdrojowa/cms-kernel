<?php

namespace Zdrojowa\CmsKernel\Events\Booter;

use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class BooterRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Booter
 */
class BooterRegisterEvent extends CmsKernelEvent
{

    /**
     * @var BooterInterface
     */
    public $booter;

    /**
     * BooterRegisterEvent constructor.
     *
     * @param BooterInterface $booter
     */
    public function __construct(BooterInterface $booter)
    {
        $this->booter = $booter;
    }
}
