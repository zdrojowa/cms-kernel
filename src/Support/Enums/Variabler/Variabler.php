<?php

namespace Zdrojowa\CmsKernel\Support\Enums\Variabler;

use MyCLabs\Enum\Enum;

/**
 * @method static CUSTOM_VARIABLE_START()
 * @method static CUSTOM_VARIABLE_END()
 */
class Variabler extends Enum
{
    const CUSTOM_VARIABLE_START = '__';
    const CUSTOM_VARIABLE_END = '__';

    const PROPERTY_VARIABLE_START = '{';
    const PROPERTY_VARIABLE_END = '}';
}
