<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Contracts\Variabler\VariablerInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class VariablerSerivceProvider
 * @package Zdrojowa\CmsKernel\Providers
 */
class VariablerSerivceProvider extends ServiceProvider
{

    /**
     *
     */
    public function register()
    {
        if (!$this->booter()->canBoot()) return;

        $this->registerVariabler();
    }

    /**
     * @return VariablerSerivceProvider
     */
    protected function registerVariabler(): VariablerSerivceProvider
    {
        $this->app->singleton(CoreModulesEnum::VARIABLER, ConfigUtils::coreModules(CoreModulesEnum::VARIABLER()));
        $this->app->bind(VariablerInterface::class, CoreModulesEnum::VARIABLER);

        $this->booter()->setCoreModuleBooted(CoreModulesEnum::VARIABLER());

        return $this;
    }

    /**
     * @return BooterInterface
     */
    protected function booter(): BooterInterface
    {
        return $this->app->get(CoreModulesEnum::BOOTER);
    }

}
