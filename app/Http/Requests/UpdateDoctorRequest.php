<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['email', 'unique:users'],
            'phone' => ['string', 'unique:users'],
            'gender' => ['string', Rule::in(User::GENDERS)],
            'birthday' => ['date'],
            'password' => ['confirmed', 'min:8', 'max:50'],
            'specialty' => ['string'],
            'description' => ['string'],
        ];
    }
}
