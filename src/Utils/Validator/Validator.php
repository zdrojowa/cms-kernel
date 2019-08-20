<?php

namespace Zdrojowa\InvestmentCMS\Utils\Validator;

/**
 * Class Validator
 * @package Zdrojowa\InvestmentCMS\Utils\Validator
 */
class Validator
{

    /**
     * @param $toValidate
     *
     * @return bool
     */
    public function string($toValidate)
    {
        return is_string($toValidate);
    }

    /**
     * @param $toValidate
     *
     * @return bool
     */
    public function array($toValidate)
    {
        return is_array($toValidate);
    }

    /**
     * @param $toValidate
     * @param array $rules
     *
     * @return bool
     */
    public static function validate($toValidate, array $rules): bool
    {
        $validator = new static();

        foreach ($rules as $rule) {
            if (!method_exists($validator, $rule)) return false;

            if (!$validator->$rule($toValidate)) return false;
        }

        return true;
    }

}
