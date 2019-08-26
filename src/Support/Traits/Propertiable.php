<?php

namespace Zdrojowa\CmsKernel\Support\Traits;

use Illuminate\Support\Facades\Validator;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Exceptions\PropertyBinder\PropertyCanNotPassValidationException;
use Zdrojowa\CmsKernel\Exceptions\PropertyBinder\PropertyIsRequiredException;
use Zdrojowa\CmsKernel\Exceptions\PropertyBinder\PropertyNameMustBeAStringException;

/**
 * Trait PropertyBinder
 * This trait is for binding property to classes based on data given
 * @package Zdrojowa\CmsKernel\Support\Traits
 */
trait Propertiable
{
    /**
     * @param array $data
     * @param array $properties
     * @param array $rules
     * @param bool $required
     *
     * @throws CmsKernelException
     */
    final public function bindProperties(array $data, array $properties, array $rules = [], bool $required = false)
    {
        foreach ($properties as $property) {
            if (!$this->validateBinder($property, $data, $rules, $required)) continue;

            $this->$property = $data[$property];
        }
    }

    /**
     * @param string $property
     * @param array $data
     * @param array $rules
     * @param bool $required
     *
     * @return bool
     * @throws CmsKernelException
     */
    final private function validateBinder($property, array $data, array $rules = [], bool $required = false): bool
    {
        // Check if property is valid string
        if (!is_string($property)) throw new PropertyNameMustBeAStringException($this);

        // Check if property is required and is not empty
        if (!array_key_exists($property, $data)) {
            if ($required) {
                if (!array_key_exists($property, $data)) throw new PropertyIsRequiredException([$this, $property]);
            }

            return false;
        }

        // Validate property based on Laravel Validation Rules in $rules variable
        if (array_key_exists($property, $rules)) {
            $validator = Validator::make([$property => $data[$property]], $rules);

            if ($validator->fails()) throw new PropertyCanNotPassValidationException([
                $property,
                $rules[$property],
            ]);
        }

        return true;
    }
}
