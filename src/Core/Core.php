<?php

namespace Zdrojowa\InvestmentCMS\Core;

use Illuminate\Support\Facades\Log;
use Zdrojowa\InvestmentCMS\Contracts\Core\CoreInterface;
use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;

/**
 * Class Core
 * @package Zdrojowa\InvestmentCMS\Core
 */
class Core implements CoreInterface
{
    /**
     * @var string
     */
    private $version = '0.0.1';

    /** @var ModuleManagerInterface $moduleManager */
    private $moduleManager;

    /**
     * @inheritDoc
     */
    public function setModuleManager(ModuleManagerInterface $moduleManager): CoreInterface
    {
        $this->moduleManager = $moduleManager;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getModuleManager(): ModuleManagerInterface
    {
        return $this->moduleManager;
    }

    /**
     * @inheritDoc
     */
    public function hasModuleManager(): bool
    {
        return $this->getModuleManager() ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = null): CoreInterface
    {
        Log::log($level, $message, $context ?? []);

        return $this;
    }
}
