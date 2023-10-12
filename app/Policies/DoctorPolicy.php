<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->isAdmin()
            || ($user->isDoctor() && $user->userable_id === $doctor->id);
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }
}
