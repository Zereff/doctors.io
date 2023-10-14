<?php

namespace App\Policies;

use App\Http\Traits\AdminAccessAbility;
use App\Models\Timeslot;
use App\Models\User;

class TimeslotPolicy
{
    use AdminAccessAbility;

    public function viewAny(User $user): bool
    {
        return $user->isDoctor();
    }

    public function view(User $user, Timeslot $slot): bool
    {
        return $user->isDoctor() && $user->userable_id === $slot->doctor_id;
    }

    public function create(User $user): bool
    {
        return $user->isDoctor();
    }
}
