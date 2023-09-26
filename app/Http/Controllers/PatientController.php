<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientCollection;
use App\Http\Resources\PatientResource;
use App\Http\Services\PatientService;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(): PatientCollection
    {
        return new PatientCollection(Patient::paginate(10));
    }

    public function store(StorePatientRequest $request, PatientService $service): PatientResource
    {
        $data = $request->validated();

        $data['role'] = User::ROLE_PATIENT;
        $data['password'] = Hash::make($request->input('password'));

        $patient = $service->store($data);

        return new PatientResource($patient);
    }

    public function show(Patient $patient): PatientResource
    {
        return new PatientResource($patient);
    }

    public function update(UpdatePatientRequest $request, Patient $patient, PatientService $service): PatientResource
    {
        $data = $request->validated();

        $patient = $service->update($patient, $data);

        return new PatientResource($patient);
    }

    public function destroy(Patient $patient, PatientService $service): void
    {
        $service->destroy($patient);
    }
}
