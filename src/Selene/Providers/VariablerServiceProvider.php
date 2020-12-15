<?php

namespace Selene\Providers;

use Illuminate\Support\ServiceProvider;
use Selene\Contracts\Booter\Booter;
use Selene\Contracts\Variabler\Variabler;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class VariablerServiceProvider
 * @package Selene\Providers
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
        $this->app->instance(Variabler::class, CoreModules::VARIABLER);

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
