<?php

namespace Zdrojowa\CmsKernel\Utils\Module;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;
use Zdrojowa\CmsKernel\Contracts\Modules\Module;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Exceptions\Modules\ModuleConfigNotFoundException;
use Zdrojowa\CmsKernel\Facades\Variabler;
use Zdrojowa\CmsKernel\Utils\Enums\ModuleConfigEnum;

/**
 * Class ModuleUtils
 * @package Zdrojowa\CmsKernel\Utils\Module
 */
class ModuleUtils
{

    /**
     * @param ModuleInterface $module
     * @param ModuleConfigEnum $config
     *
     * @param bool $required
     *
     * @return array|null
     * @throws ModuleConfigNotFoundException
     * @throws ReflectionException
     */
    public static function moduleConfig(ModuleInterface $module, ModuleConfigEnum $config, bool $required = false): ?array
    {
        $module = new ReflectionClass($module);
        $config = Variabler::make($config, $module);
        $module->dir = dirname($module->getFileName());
        $module->config = $module->dir . '/' . ModuleConfigEnum::MODULES_CONFIG_FOLDER . $config;

        if (!file_exists($module->config)) {
            if (!$required) {
                return [];
            }
            throw new ModuleConfigNotFoundException([$module->getShortName(), $config]);
        }

        $module->data = Yaml::parseFile($module->config, Yaml::PARSE_OBJECT);

        return $module->data;
    }
}
