<?php

namespace Zdrojowa\InvestmentCMS\Events\Booter;

use Zdrojowa\InvestmentCMS\Contracts\Core\BooterInterface;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

/**
 * Class BooterRegisterEvent
 * @package Zdrojowa\InvestmentCMS\Events\Booter
 */
class BooterRegisterEvent extends InvestmentCMSEvent
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
