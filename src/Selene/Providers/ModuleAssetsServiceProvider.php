<?php

namespace Selene\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Selene\Contracts\Booter\Booter;
use Selene\Contracts\Modules\Module;
use Selene\Contracts\Modules\ModuleManager;
use Selene\Exceptions\CmsExceptionHandler;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class ModuleAssetsServiceProvider
 * @package Selene\Providers
 */
class ModuleAssetsServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function boot()
    {
        if (!$this->booter()->canBoot()) return;

        try {
            $this->publishModulesAssets($this->moduleManager());
        } catch (ReflectionException $exception) {
            CmsExceptionHandler::handle($exception);
        }
    }

    /**
     * @param ModuleManager $manager
     *
     * @return ModuleAssetsServiceProvider
     * @throws ReflectionException
     */
    protected function publishModulesAssets(ModuleManager $manager): ModuleAssetsServiceProvider
    {
        foreach ($manager->getModules() as $module) {
            $this->loadAndPublishModuleAssets($module);
        }

        return $this;
    }

    /**
     * @param Module $module
     *
     * @throws ReflectionException
     */
    protected function loadAndPublishModuleAssets(Module $module)
    {
        $reflection = new ReflectionClass($module);
        $moduleSrc = dirname($reflection->getFileName());

        $assets = [
            'js' => $moduleSrc . '/../resources/js',
            'sass' => $moduleSrc . '/../resources/sass',
            'assets' => $moduleSrc . '/../resources/assets/',
            'translations' => $moduleSrc . '/../resources/lang/',
            'views' => $moduleSrc . '/../resources/views/',
        ];

        $assetsPublishedPaths = [
            'js' => resource_path('js/vendor/' . $module::name()),
            'sass' => resource_path('sass/vendor/' . $module::name()),
            'assets' => resource_path('assets/vendor/' . $module::name()),
            'translations' => resource_path('lang/vendor/' . $module::name()),
            'views' => resource_path('views/vendor/' . $module::name() . '/'),
        ];

        foreach ($assets as $type => $directory) {

            if (file_exists($directory)) {
                switch ($type) {
                    case 'translations':
                        $this->loadTranslationsFrom($directory, $module::name());
                        break;
                    case 'views':
                        $this->loadViewsFrom($directory, $module::name());
                        break;
                }

                $this->publishes([$directory => $assetsPublishedPaths[$type]]);
            }
        }
    }

    /**
     * @return Booter
     */
    protected function booter(): Booter
    {
        return $this->app->get(CoreModules::BOOTER);
    }

    /**
     * @return ModuleManager
     */
    protected function moduleManager(): ModuleManager
    {
        return $this->app->get(CoreModules::MODULE_MANAGER);
    }
}
