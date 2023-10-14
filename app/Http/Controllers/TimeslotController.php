<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeslotRequest;
use App\Http\Requests\UpdateTimeslotRequest;
use App\Http\Resources\TimeslotCollection;
use App\Http\Resources\TimeslotResource;
use App\Models\Timeslot;

class TimeslotController extends Controller
{
    public function index(): TimeslotCollection
    {
        $this->authorize('viewAny', Timeslot::class);

        $user = \Auth::user();

        return new TimeslotCollection(Timeslot::getAll($user));
    }

    public function store(StoreTimeslotRequest $request): TimeslotResource
    {
        $user = \Auth::user();
        $data = $request->validated();

        if ($user->isDoctor()) {
            $data['doctor_id'] = $user->userable_id;
        }

        $timeslot = Timeslot::create($data);

        return new TimeslotResource($timeslot);
    }

    public function show(Timeslot $timeslot): TimeslotResource
    {
        $this->authorize('view', $timeslot);

        return new TimeslotResource($timeslot->load('doctor.user'));
    }

    public function update(UpdateTimeslotRequest $request, Timeslot $timeslot): TimeslotResource
    {
        $data = $request->validated();

        $timeslot->update($data);

        return new TimeslotResource($timeslot);
    }

    public function destroy(Timeslot $timeslot): void
    {
        $this->authorize('before', $timeslot);

        $timeslot->delete();
    }
}
