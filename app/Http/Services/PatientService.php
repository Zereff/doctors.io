<?php

namespace App\Http\Services;

use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientService
{
    public function store(array $data)
    {
        return DB::transaction(function() use ($data) {
            $patient = Patient::create($data);
            $patient->user()->create($data);

            return $patient;
        });
    }

    public function update(Patient $patient, array $data)
    {
        return DB::transaction(function () use ($patient, $data) {
            $patient->update($data);

            $userData = array_filter($data, function ($key) use ($patient) {
                return !array_key_exists($key, $patient->getAttributes());
            }, ARRAY_FILTER_USE_KEY);

            $patient->user()->update($userData);

            return $patient;
        });
    }

    public function destroy(Patient $patient)
    {
        return DB::transaction(function () use ($patient) {
            $patient->user()->delete();
            $patient->delete();
        });
    }
}
