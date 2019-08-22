<?php

namespace Zdrojowa\CmsKernel\Utils\Enums;

use MyCLabs\Enum\Enum;

class BooterEnum extends Enum
{
    private const START = 'start';

    private const BOOTING = 'booting';

    private const BOOTED = 'booted';
}
