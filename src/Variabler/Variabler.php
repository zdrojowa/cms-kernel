<?php

namespace Zdrojowa\CmsKernel\Variabler;

use Illuminate\Config\Repository;
use Zdrojowa\CmsKernel\Contracts\Variabler\VariableProviderInterface;
use Zdrojowa\CmsKernel\Contracts\Variabler\VariablerInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\VariableEnum;

/**
 * Class Variabler
 * @package Zdrojowa\CmsKernel\Variabler
 *
 * @method property($data, $object)
 * @method name($data, $object)
 */
class Variabler implements VariablerInterface
{

    /**
     * @var Repository|mixed
     */
    private $providers;

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

        return $this->replaceVariable($data, $object);
    }

    /**
     * @param $data
     * @param object|null $object
     *
     * @return array|mixed|string
     */
    private function replaceVariable($data, object $object = null)
    {
        if (is_string($data)) {
            foreach ($this->providers as $name => $provider) {
                $data = $this->replaceObjectCustomVariable($data, $name, $provider, $object);
            }

            $data = $this->replaceObjectPropertyVariable($data, $object);
        }

        return $data;
    }

    /**
     * @param $data
     * @param object|null $object
     *
     * @return array|mixed
     */
    private function replaceObjectPropertyVariable($data, object $object = null)
    {
        preg_match('/' . VariableEnum::OBJECT_PROPERTY_VARIABLE_START . '(.*?)' . VariableEnum::OBJECT_PROPERTY_VARIABLE_END . '/', $data, $matches);

        if (!empty($matches[0]) && !empty($matches[1])) {
            $variabled = $this->property($matches[1], $object);

            if (is_array($variabled)) {
                $data = $variabled;
            } else {
                $data = str_replace($matches[0], $variabled, $data);
            }
        }

        return $data;
    }

    /**
     * @param string $data
     * @param string $providerName
     * @param string $provider
     * @param object $object
     *
     * @return mixed|string
     */
    private function replaceObjectCustomVariable(string $data, string $providerName, string $provider, object $object)
    {
        $tag = $this->getKey(VariableEnum::OBJECT_CUSTOM_VARIABLE_START(), VariableEnum::OBJECT_CUSTOM_VARIABLE_END(), $providerName);

        if (strpos($data, $tag) !== false) {
            $data = str_replace($tag, $this->$providerName($data, $object), $data);
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

        if (!is_subclass_of($provider, VariableProviderInterface::class)) return;

        return $provider->replace($arguments[0], $arguments[1]);
    }
}
