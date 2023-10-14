<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isPatient();
    }

    public function create(User $user): bool
    {
        return $user->isPatient();
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->isPatient() && $user->userable_id === $appointment->patient_id;
    }
}
