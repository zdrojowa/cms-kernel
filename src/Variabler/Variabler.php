<?php

namespace Zdrojowa\CmsKernel\Variabler;

use Zdrojowa\CmsKernel\Contracts\Variabler\VariablerInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\VariableEnum;

/**
 * Class Variabler
 * @package Zdrojowa\CmsKernel\Variabler
 */
class Variabler implements VariablerInterface
{

    /**
     * Variabler constructor.
     */
    public function __construct()
    {
        $this->providers = ConfigUtils::coreConfig(CoreEnum::VARIABLER_PROVIDERS_SECTION);
    }

    /**
     * @param $data
     * @param object|null $object
     *
     * @return array|mixed
     */
    public function make($data, object $object = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::make($value, $object);
            }
        }

        if (is_string($data)) {
            foreach ($this->providers as $name => $provider) {
                $tag = $this->getKey(VariableEnum::OBJECT_CUSTOM_VARIABLE_START(), VariableEnum::OBJECT_CUSTOM_VARIABLE_END(), $name);

                if (strpos($data, $tag) === false) continue;

                $data = str_replace($tag, $this->$name($data, $object), $data);
            }

            preg_match('/' . VariableEnum::OBJECT_PROPERTY_VARIABLE_START . '(.*?)' . VariableEnum::OBJECT_PROPERTY_VARIABLE_END . '/', $data, $matches);

            if (!empty($matches[0]) && !empty($matches[1])) {
                $data = str_replace($matches[0], $this->property($matches[1], $object), $data);
            }

        }

        return $data;
    }

    /**
     * @param VariableEnum $tag
     * @param VariableEnum $secondTag
     * @param $key
     *
     * @return string
     */
    public function getKey(VariableEnum $tag, VariableEnum $secondTag, $key)
    {
        return $tag . $key . $secondTag;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if (!array_key_exists($name, $this->providers)) return;

        $provider = app($this->providers[$name]);

        return $provider->replace($arguments[0], $arguments[1]);
    }
}
