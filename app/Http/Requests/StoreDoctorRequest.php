<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('before', Doctor::class);
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
            'specialty' => ['required', 'string'],
            'description' => ['string'],
        ];
    }
}
