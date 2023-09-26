<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeslotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['int', 'exists:doctors,id'],
            'date' => ['date_format:format,Y-m-d'],
            'start_time' => ['date_format:format,H:i'],
            'end_time' => ['date_format:format,H:i'],
        ];
    }
}
