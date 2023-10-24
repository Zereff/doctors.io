<?php

namespace App\Enums;

use App\Enums\Traits\EnumValuesTrait;

enum Gender: string
{
    use EnumValuesTrait;

    case Male = 'm';
    case Female = 'f';
}
