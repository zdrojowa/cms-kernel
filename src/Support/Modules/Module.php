<?php

namespace Zdrojowa\CmsKernel\Support\Modules;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;
use Zdrojowa\CmsKernel\Contracts\Modules\Module as ModuleContract;
use Zdrojowa\CmsKernel\Modules\Exceptions\ModuleConfigNotFoundException;
use Zdrojowa\CmsKernel\Support\Facades\Variabler;
use Zdrojowa\CmsKernel\Support\Enums\Modules\ModuleConfig;

/**
 * Class Module
 * @package Zdrojowa\CmsKernel\Support\Modules
 */
class Module
{

    /**
     * @param ModuleContract $module
     * @param ModuleConfig $config
     * @param bool $required
     *
     * @return array|null
     * @throws ModuleConfigNotFoundException
     * @throws ReflectionException
     */
    public static function config(ModuleContract $module, ModuleConfig $config, bool $required = false): ?array
    {
        $module = new ReflectionClass($module);
        $config = Variabler::make($config->getValue(), $module);
        $module->dir = dirname($module->getFileName());
        $module->config = $module->dir . '/' . ModuleConfig::CONFIG_FOLDER . $config;

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
