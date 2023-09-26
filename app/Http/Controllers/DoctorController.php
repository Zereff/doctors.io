<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Http\Services\DoctorService;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(): DoctorCollection
    {
        return new DoctorCollection(Doctor::paginate(10));
    }

    public function store(StoreDoctorRequest $request, DoctorService $service): DoctorResource
    {
        $data = $request->validated();
        $data['role'] = User::ROLE_DOCTOR;
        $data['password'] = Hash::make($request->input('password'));

        $doctor = $service->store($data);

        return new DoctorResource($doctor);
    }

    public function show(Doctor $doctor): DoctorResource
    {
        return new DoctorResource($doctor);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor, DoctorService $service): DoctorResource
    {
        $data = $request->validated();

        $doctor = $service->update($doctor, $data);

        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor, DoctorService $service): void
    {
        $service->destroy($doctor);
    }
}
