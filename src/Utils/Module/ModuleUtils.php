<?php

namespace Zdrojowa\InvestmentCMS\Utils\Module;

use Exception;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;
use Zdrojowa\InvestmentCMS\Contracts\Modules\Module;
use Zdrojowa\InvestmentCMS\Exceptions\Modules\ModuleConfigNotFoundException;
use Zdrojowa\InvestmentCMS\Facades\Core;
use Zdrojowa\InvestmentCMS\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\ModuleEnum;

/**
 * Class ModuleUtils
 * @package Zdrojowa\InvestmentCMS\Utils\Module
 */
class ModuleUtils
{

    /**
     * @param Module $module
     * @param ModuleConfigEnum $config
     *
     * @param bool $required
     *
     * @return array|null
     * @throws ModuleConfigNotFoundException
     * @throws ReflectionException
     */
    public static function moduleConfig(Module $module, ModuleConfigEnum $config, bool $required = false): ?array
    {
        $module = new ReflectionClass($module);
        $config = str_replace('%name%', $module->getShortName(), $config);
        $module->dir = dirname($module->getFileName());
        $module->config = $module->dir . '/../module-config/' . $config;

        if (!file_exists($module->config)) {
            if(!$required) {
                return [];
            }
            throw new ModuleConfigNotFoundException([$module->getShortName(), $config]);
        }

        $module->data = Yaml::parseFile($module->config, Yaml::PARSE_OBJECT);

        return $module->data;
    }
}
