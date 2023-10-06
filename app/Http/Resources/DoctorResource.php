<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'specialty' => $this->specialty,
            'description' => $this->description,
            'availabilities' => $this->availabilities,
            'timeslots' => $this->timeslots,
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
