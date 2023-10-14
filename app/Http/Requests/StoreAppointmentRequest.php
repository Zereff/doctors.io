<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Appointment::class);
    }

    public function rules(): array
    {
        return [
            'timeslot_id' => ['required', 'int', 'exists:timeslots,id', 'unique:patient_timeslots'],
        ];
    }
}
