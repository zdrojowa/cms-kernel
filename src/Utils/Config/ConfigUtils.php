<?php

namespace Zdrojowa\CmsKernel\Utils\Config;

use Illuminate\Config\Repository;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class ConfigUtils
 * @package Zdrojowa\CmsKernel\Utils\Config
 */
class ConfigUtils
{
    /**
     * @param string $key
     *
     * @return Repository|mixed
     */
    public static function coreConfig(string $key)
    {
        return config(CoreEnum::CMS_CONFIG . "." . $key);
    }

    /**
     * @param CoreModulesEnum $coreModule
     *
     * @return Repository|mixed
     */
    public static function coreModules(CoreModulesEnum $coreModule)
    {
        return self::coreConfig(CoreEnum::CORE_MODULES_SECTION . '.' . $coreModule);
    }

    /**
     * @return array
     */
    public static function getAvailableHttpMethods()
    {
        return [
            'GET',
            'HEAD',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'OPTIONS',
        ];
    }
}
