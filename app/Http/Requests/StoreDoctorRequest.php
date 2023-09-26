<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'gender' => ['required', 'int', Rule::in(User::GENDERS)],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'confirmed', 'min:8', 'max:50'],
            'specialty' => ['required', 'string'],
            'description' => ['string'],
        ];
    }
}
