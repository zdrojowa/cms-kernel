<?php

namespace Zdrojowa\InvestmentCMS\Core;

use Zdrojowa\InvestmentCMS\Contracts\Core\BooterInterface;
use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\BooterEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreModulesEnum;

/**
 * Class Booter
 * @package Zdrojowa\InvestmentCMS\Core
 */
class Booter implements BooterInterface
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * Booter constructor.
     */
    public function __construct()
    {
        $this->enabled = false;
    }

    /**
     * @return bool
     */
    public function isCmsEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return BooterInterface
     */
    public function markCmsEnabled(): BooterInterface
    {
        $this->enabled = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function canCmsBoot(): bool
    {
        return ConfigUtils::coreConfig(CoreEnum::CMS_ENABLED_OPTION);
    }
}
