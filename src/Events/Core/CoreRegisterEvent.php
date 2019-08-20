<?php

namespace Zdrojowa\InvestmentCMS\Events\Core;

use Zdrojowa\InvestmentCMS\Contracts\Core\CoreInterface;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

/**
 * Class CoreRegisterEvent
 * @package Zdrojowa\InvestmentCMS\Events\Core
 */
class CoreRegisterEvent extends InvestmentCMSEvent
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
