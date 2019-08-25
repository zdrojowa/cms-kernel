<?php

namespace Zdrojowa\CmsKernel\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Exceptions\CmsExceptionHandler;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class ModuleAssetsServiceProvider
 * @package Zdrojowa\CmsKernel\Providers
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
     * @param ModuleManagerInterface $manager
     *
     * @return ModuleAssetsServiceProvider
     * @throws ReflectionException
     */
    protected function publishModulesAssets(ModuleManagerInterface $manager): ModuleAssetsServiceProvider
    {
        foreach ($manager->getModules() as $module) {
            $this->loadAndPublishModuleAssets($module);
        }

        return $this;
    }

    /**
     * @param ModuleInterface $module
     *
     * @throws ReflectionException
     */
    protected function loadAndPublishModuleAssets(ModuleInterface $module)
    {
        $reflection = new ReflectionClass($module);
        $moduleSrc = dirname($reflection->getFileName());

        $assets = [
            'js' => $moduleSrc . '/../resources/assets/js',
            'sass' => $moduleSrc . '/../resources/assets/sass',
            'img' => $moduleSrc . '/../resources/assets/img',
            'translations' => $moduleSrc . '/../resources/lang/',
            'views' => $moduleSrc . '/../resources/views/',
        ];

        $assetsPublishedPaths = [
            'js' => resource_path('js/vendor/' . $module::name()),
            'sass' => resource_path('sass/vendor/' . $module::name()),
            'img' => resource_path('assets/vendor/' . $module::name()),
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
     * @return BooterInterface
     */
    protected function booter(): BooterInterface
    {
        return $this->app->get(CoreModulesEnum::BOOTER);
    }

    /**
     * @return ModuleManagerInterface
     */
    protected function moduleManager(): ModuleManagerInterface
    {
        return $this->app->get(CoreModulesEnum::MODULE_MANAGER);
    }
}
