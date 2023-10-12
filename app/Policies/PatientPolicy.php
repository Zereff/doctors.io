<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->isAdmin()
            || ($user->isPatient() && $user->userable_id === $patient->id);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->isAdmin()
            || ($user->isPatient() && $user->userable_id === $patient->id);
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }
}
