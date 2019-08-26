<?php

namespace Zdrojowa\CmsKernel\Variabler;

use Illuminate\Config\Repository;
use Zdrojowa\CmsKernel\Contracts\Variabler\VariableProvider;
use Zdrojowa\CmsKernel\Contracts\Variabler\Variabler as VariablerContract;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;
use Zdrojowa\CmsKernel\Support\Enums\Variabler\Variabler as VariablerEnum;
use Zdrojowa\CmsKernel\Variabler\Exceptions\ProviderInstanceException;
use Zdrojowa\CmsKernel\Variabler\Exceptions\ProviderNotFoundException;

/**
 * Class Variabler
 * @package Zdrojowa\CmsKernel\Variabler
 *
 * @method property($data, $object)
 * @method name($data, $object)
 */
class Variabler implements VariablerContract
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
        $this->providers = Config::get(Core::VARIABLER_PROVIDERS);
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
                $data = $this->replaceObjectCustomVariable($data, $name, $object);
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
        preg_match('/' . VariablerEnum::PROPERTY_VARIABLE_START . '(.*?)' . VariablerEnum::PROPERTY_VARIABLE_END . '/', $data, $matches);

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
     * @param object $object
     *
     * @return mixed|string
     */
    private function replaceObjectCustomVariable(string $data, string $providerName, object $object)
    {
        $tag = $this->getKey(VariablerEnum::CUSTOM_VARIABLE_START(), VariablerEnum::CUSTOM_VARIABLE_END(), $providerName);

        if (strpos($data, $tag) !== false) {
            $data = str_replace($tag, $this->$providerName($data, $object), $data);
        }

        return $data;
    }

    /**
     * @param VariablerEnum $tag
     * @param VariablerEnum $secondTag
     * @param $key
     *
     * @return string
     */
    public function getKey(VariablerEnum $tag, VariablerEnum $secondTag, $key)
    {
        return $tag . $key . $secondTag;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws ProviderInstanceException
     * @throws ProviderNotFoundException
     */
    public function __call($name, $arguments)
    {
        if (!array_key_exists($name, $this->providers)) throw new ProviderNotFoundException($name);

        $provider = app($this->providers[$name]);

        if (!is_subclass_of($provider, VariableProvider::class)) throw new ProviderInstanceException(get_class($provider));

        return $provider->replace($arguments[0], $arguments[1]);
    }
}
