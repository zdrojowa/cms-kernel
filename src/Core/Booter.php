<?php

namespace Zdrojowa\CmsKernel\Core;

use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\BooterEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class Booter
 * @package Zdrojowa\CmsKernel\Core
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
