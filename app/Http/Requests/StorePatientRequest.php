<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('before', Patient::class);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'gender' => ['required', new Enum(Gender::class)],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'confirmed', 'min:8', 'max:50'],
        ];
    }
}
