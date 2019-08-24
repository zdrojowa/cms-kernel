<?php

namespace Zdrojowa\CmsKernel\Utils\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class BooterEnum
 * @package Zdrojowa\CmsKernel\Utils\Enums
 */
class BooterEnum extends Enum
{
    private const START = 'start';

    private const BOOTING = 'booting';

    private const BOOTED = 'booted';
}
