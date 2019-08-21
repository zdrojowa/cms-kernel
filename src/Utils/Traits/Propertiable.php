<?php

namespace Zdrojowa\InvestmentCMS\Utils\Traits;

use Exception;
use Validator;
use Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder\PropertyCanNotPassValidationException;
use Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder\PropertyIsRequiredException;
use Zdrojowa\InvestmentCMS\Exceptions\PropertyBinder\PropertyNameMustBeAStringException;
use Zdrojowa\InvestmentCMS\Utils\Variabler\Variabler;

/**
 * Trait PropertyBinder
 * @package Zdrojowa\InvestmentCMS\Utils\Traits
 */
trait Propertiable
{
    /**
     * @param array $data
     * @param array $properties
     * @param array $rules
     * @param bool $required
     *
     * @throws Exception
     */
    final private function bindProperties(array $data, array $properties, array $rules = [], bool $required = false)
    {
        foreach ($properties as $property) {
            if (!is_string($property)) throw new PropertyNameMustBeAStringException();

            if (!array_key_exists($property, $data)) {
                if ($required) {
                    if (!array_key_exists($property, $data)) throw new PropertyIsRequiredException($property);
                }

                continue;
            }

            if (array_key_exists($property, $rules)) {
                $validator = Validator::make([$property => $data[$property]], $rules);

                if ($validator->fails()) throw new PropertyCanNotPassValidationException([
                    $property,
                    $rules[$property],
                ]);
            }

            $this->$property = Variabler::replace($this, $data[$property]);
        }
    }
}
