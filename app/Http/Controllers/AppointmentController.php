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
        $this->authorize('viewAny', Appointment::class);

        $user = \Auth::user();
        $appointments = Appointment::where('patient_id', $user->userable_id)->with('timeslot');

        return new AppointmentCollection($appointments->paginate());
    }

    public function store(StoreAppointmentRequest $request): AppointmentResource
    {
        $data = $request->validated();

        $patientId = \Auth::user()->userable_id;

        /** @var Patient $patient */
        $patient = Patient::findOrFail($patientId);

        $appointment = $patient->appointments()->create([
            'timeslot_id' => $data['timeslot_id']
        ]);

        return new AppointmentResource($appointment->load('timeslot'));
    }

    public function destroy(Appointment $appointment): void
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();
    }
}
