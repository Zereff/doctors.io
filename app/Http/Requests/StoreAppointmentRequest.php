<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'int', 'exists:patients,id'],
            'timeslot_id' => ['required', 'int', 'exists:timeslots,id', 'unique:patient_timeslots'],
        ];
    }
}
