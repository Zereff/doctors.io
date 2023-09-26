<?php

namespace App\Http\Services;

use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class DoctorService
{
    public function store(array $data)
    {
        return DB::transaction(function() use ($data) {
            $doctor = Doctor::create($data);
            $doctor->user()->create($data);

            return $doctor;
        });
    }

    public function update(Doctor $doctor, array $data)
    {
        return DB::transaction(function () use ($doctor, $data) {
            $doctor->update($data);

            $userData = array_filter($data, function ($key) use ($doctor) {
                return !array_key_exists($key, $doctor->getAttributes());
            }, ARRAY_FILTER_USE_KEY);

            $doctor->user()->update($userData);

            return $doctor;
        });
    }

    public function destroy(Doctor $doctor)
    {
        return DB::transaction(function () use ($doctor) {
            $doctor->user()->delete();
            $doctor->delete();
        });
    }
}
