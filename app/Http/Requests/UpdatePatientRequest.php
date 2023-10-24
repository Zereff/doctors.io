<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('patient'));
    }

    public function rules(): array
    {
        $user = \Auth::user();

        if (! $user->isDoctor()) {
            $rules =  [
                'first_name' => ['string'],
                'last_name' => ['string'],
                'email' => ['email', 'unique:users'],
                'phone' => ['string', 'unique:users'],
                'gender' => [new Enum(Gender::class)],
                'birthday' => ['date'],
                'password' => ['confirmed', 'min:8', 'max:50'],
            ];
        } else {
            $rules['disease_history'] = ['string'];
        }

        return $rules;
    }
}
