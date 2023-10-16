<?php

namespace App\Policies;

use App\Http\Traits\AdminAccessAbility;
use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    use AdminAccessAbility;

    public function view(User $user, Patient $patient): bool
    {
        return $user->isPatient() && $user->userable_id === $patient->id;
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->isDoctor()
            || ($user->isPatient() && $user->userable_id === $patient->id);
    }
}
