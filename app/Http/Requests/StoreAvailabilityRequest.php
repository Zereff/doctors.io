<?php

namespace App\Http\Requests;

use App\Models\Availability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'int', 'exists:doctors,id'],
            'day_of_week' => [
                'required',
                'int',
                Rule::in(Availability::DAYS),
            ],
            'start_time' => ['required', 'date_format:format,H:i'],
            'end_time' => ['required', 'date_format:format,H:i'],
        ];
    }
}
