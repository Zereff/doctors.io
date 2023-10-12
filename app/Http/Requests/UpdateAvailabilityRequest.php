<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('availability'));
    }

    public function rules(): array
    {
        return [
            'start_time' => ['date_format:format,H:i'],
            'end_time' => ['date_format:format,H:i'],
        ];
    }
}
