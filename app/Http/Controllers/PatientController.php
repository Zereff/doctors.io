<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientCollection;
use App\Http\Resources\PatientResource;
use App\Http\Services\PatientService;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(): PatientCollection
    {
        $this->authorize('before', Patient::class);

        return new PatientCollection(Patient::paginate(10));
    }

    public function store(StorePatientRequest $request, PatientService $service): PatientResource
    {
        $data = $request->validated();

        $data['role'] = Role::Patient->value;
        $data['password'] = Hash::make($request->input('password'));

        $patient = $service->store($data);

        return new PatientResource($patient);
    }

    public function show(Patient $patient): PatientResource
    {
        $this->authorize('view', Patient::class);

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
        $this->authorize('before', Patient::class);

        $service->destroy($patient);
    }
}
