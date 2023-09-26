<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'disease_history' => $this->disease_history,
            'user' => [
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'gender' => $this->user->gender,
                'birthday' => $this->user->birthday,
                'updated_at' => $this->user->updated_at,
                'created_at' => $this->user->created_at,
            ],
        ];
    }
}
