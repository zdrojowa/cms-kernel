<?php

namespace Zdrojowa\CmsKernel\Utils\Variabler;

use Zdrojowa\CmsKernel\Utils\Enums\VariableEnum;
use Zdrojowa\CmsKernel\Utils\Variabler\Providers\ObjectNameProvider;
use Zdrojowa\CmsKernel\Utils\Variabler\Providers\ObjectPropertyProvider;

/**
 * @method static property($object, $int)
 */
class Variabler
{

    /**
     *
     */
    private const PROVIDERS = [
        'name' => ObjectNameProvider::class,
        'property' => ObjectPropertyProvider::class,
    ];

    /**
     * @param $object
     * @param string $key
     *
     * @return mixed|string
     */
    public static function replace($object, string $key)
    {
        foreach (self::PROVIDERS as $name => $provider) {
            $tag = self::getKey(VariableEnum::OBJECT_CUSTOM_VARIABLE_START(), VariableEnum::OBJECT_CUSTOM_VARIABLE_END(), $name);
            if (strpos($key, $tag) === false) continue;

            $key = str_replace($tag, self::$name($object, $key), $key);
        }

        preg_match('/' . VariableEnum::OBJECT_PROPERTY_VARIABLE_START . '(.*?)' . VariableEnum::OBJECT_PROPERTY_VARIABLE_END . '/', $key, $matches);

        if (!empty($matches[0]) && !empty($matches[1])) {
            $key = str_replace($matches[0], self::property($object, $matches[1]), $key);
        }

        return $key;

    }

    /**
     * @param VariableEnum $tag
     * @param VariableEnum $secondTag
     * @param $key
     *
     * @return string
     */
    public static function getKey(VariableEnum $tag, VariableEnum $secondTag, $key)
    {
        return $tag . $key . $secondTag;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        if (!array_key_exists($name, self::PROVIDERS)) return;

        $provider = app(self::PROVIDERS[$name]);

        return $provider->replace($arguments[0], $arguments[1]);
    }
}
