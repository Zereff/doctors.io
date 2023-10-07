<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Resources\AppointmentCollection;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Patient;

class AppointmentController extends Controller
{
    public function index(): AppointmentCollection
    {
        return new AppointmentCollection(Appointment::with('timeslot')->paginate());
    }

    public function store(StoreAppointmentRequest $request): AppointmentResource
    {
        $data = $request->validated();

        /** @var Patient $patient */
        $patient = Patient::findOrFail($data['patient_id']);

        $appointment = $patient->appointments()->create([
            'timeslot_id' => $data['timeslot_id']
        ]);

        return new AppointmentResource($appointment->load('timeslot'));
    }

    public function destroy(Appointment $appointment): void
    {
        $appointment->delete();
    }
}
