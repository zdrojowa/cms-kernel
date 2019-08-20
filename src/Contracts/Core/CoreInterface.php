<?php

namespace Zdrojowa\InvestmentCMS\Contracts\Core;

use Zdrojowa\InvestmentCMS\Contracts\Modules\ModuleManagerInterface;

/**
 * Interface CoreInterface
 * @package Zdrojowa\InvestmentCMS\Contracts\Core
 */
interface CoreInterface
{

    /**
     * @param ModuleManagerInterface $moduleManager
     *
     * @return CoreInterface
     */
    public function setModuleManager(ModuleManagerInterface $moduleManager): CoreInterface;

    /**
     * @return ModuleManagerInterface|null
     */
    public function getModuleManager(): ?ModuleManagerInterface;

    /**
     * @return bool
     */
    public function hasModuleManager(): bool;

    /**
     * @return string
     */
    public function version(): string;

    /**
     * @param $level
     * @param $message
     * @param array|null $context
     *
     * @return CoreInterface
     */
    public function log($level, $message, array $context = null): CoreInterface;

}
