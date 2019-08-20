<?php


namespace Zdrojowa\InvestmentCMS\Events\Core;


use Zdrojowa\InvestmentCMS\Contracts\Core\CoreInterface;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

/**
 * Class CoreBootedEvent
 * @package Zdrojowa\InvestmentCMS\Events\Core
 */
class CoreBootedEvent extends InvestmentCMSEvent
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
