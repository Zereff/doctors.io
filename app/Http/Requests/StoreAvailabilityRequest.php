<?php

namespace App\Http\Requests;

use App\Models\Availability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Availability::class);
    }

    public function rules(): array
    {
        $user = \Auth::user();

        $rules = [
            'day_of_week' => [
                'required',
                'int',
                Rule::in(Availability::DAYS),
            ],
            'start_time' => ['required', 'date_format:format,H:i'],
            'end_time' => ['required', 'date_format:format,H:i'],
        ];

        if ($user->isAdmin()) {
            $rules['doctor_id'] = ['required', 'int', 'exists:doctors,id'];
        }

        return $rules;
    }
}
