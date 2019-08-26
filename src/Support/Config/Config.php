<?php

namespace Zdrojowa\CmsKernel\Support\Config;

use Zdrojowa\CmsKernel\Support\Enums\Core\Core;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class Config
 * @package Zdrojowa\CmsKernel\Support\Config
 */
class Config
{
    /**
     * @param string $key
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function get(string $key)
    {
        return config(Core::CONFIG . "." . $key);
    }

    /**
     * @param CoreModules $coreModule
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function coreModules(CoreModules $coreModule)
    {
        return self::get(Core::CORE_MODULES . '.' . $coreModule);
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
