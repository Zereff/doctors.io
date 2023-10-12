<?php

namespace App\Http\Traits;

use App\Models\User;

trait AdminAccessAbility
{
    public function before(User $user): bool
    {
        return $user->isAdmin();
    }
}
