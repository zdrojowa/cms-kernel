<?php

namespace Zdrojowa\InvestmentCMS\Utils\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static OBJECT_CUSTOM_VARIABLE_START()
 * @method static OBJECT_CUSTOM_VARIABLE_END()
 */
class VariableEnum extends Enum
{

    const OBJECT_CUSTOM_VARIABLE_START = '__';
    const OBJECT_CUSTOM_VARIABLE_END = '__';

    const OBJECT_PROPERTY_VARIABLE_START = '{';
    const OBJECT_PROPERTY_VARIABLE_END = '}';
}
