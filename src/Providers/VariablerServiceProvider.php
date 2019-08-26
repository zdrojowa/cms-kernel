<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use Zdrojowa\CmsKernel\Contracts\Booter\Booter;
use Zdrojowa\CmsKernel\Contracts\Variabler\Variabler;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class VariablerServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
 */
class VariablerServiceProvider extends ServiceProvider
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
     * @return VariablerServiceProvider
     */
    protected function registerVariabler(): VariablerServiceProvider
    {
        $this->app->singleton(CoreModules::VARIABLER, Config::coreModules(CoreModules::VARIABLER()));
        $this->app->bind(Variabler::class, CoreModules::VARIABLER);

        $this->booter()->setCoreModuleBooted(CoreModules::VARIABLER());

        return $this;
    }

    /**
     * @return Booter
     */
    protected function booter(): Booter
    {
        return $this->app->get(CoreModules::BOOTER);
    }

}
