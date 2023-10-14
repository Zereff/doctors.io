<?php

namespace App\Policies;

use App\Http\Traits\AdminAccessAbility;
use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    use AdminAccessAbility;

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->isDoctor() && $user->userable_id === $doctor->id;
    }
}
