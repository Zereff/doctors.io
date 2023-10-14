<?php

namespace App\Http\Requests;

use App\Models\Timeslot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreTimeslotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Timeslot::class);
    }

    public function rules(): array
    {
        $rules = [
            'date' => ['required', 'date_format:format,Y-m-d'],
            'start_time' => ['required', 'date_format:format,H:i'],
            'end_time' => ['required', 'date_format:format,H:i'],
        ];

        $user = \Auth::user();

        if ($user->isAdmin()) {
            $rules['doctor_id'] = ['required', 'int', 'exists:doctors,id'];
        }

        return $rules;
    }
}
