<?php

namespace App\Enums;

use App\Enums\Traits\EnumValuesTrait;

enum Role: string
{
    use EnumValuesTrait;

    case Admin = 'admin';
    case Patient = 'patient';
    case Doctor = 'doctor';
}
