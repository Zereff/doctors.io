<?php

namespace App\Http\Requests;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Patient::class);
    }

    public function rules(): array
    {
        $user = \Auth::user();

        $rules = [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'gender' => ['required', 'int', Rule::in(User::GENDERS)],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'confirmed', 'min:8', 'max:50'],
        ];

        if ($user->isDoctor()) {
            $rules['disease_history'] = ['string'];
        }

        return $rules;
    }
}
