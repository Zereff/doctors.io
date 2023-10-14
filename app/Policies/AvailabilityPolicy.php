<?php

namespace App\Policies;

use App\Http\Traits\AdminAccessAbility;
use App\Models\Availability;
use App\Models\User;

class AvailabilityPolicy
{
    use AdminAccessAbility;

    public function viewAny(User $user): bool
    {
        return $user->isDoctor();
    }

    public function view(User $user, Availability $availability): bool
    {
        return $user->isDoctor() && $user->userable_id === $availability->doctor_id;
    }

    public function create(User $user): bool
    {
        return $user->isDoctor();
    }

    public function update(User $user, Availability $availability): bool
    {
        return $user->isDoctor() && $user->userable_id === $availability->doctor_id;
    }

    public function delete(User $user, Availability $availability): bool
    {
        return $user->isDoctor() && $user->userable_id === $availability->doctor_id;
    }
}
