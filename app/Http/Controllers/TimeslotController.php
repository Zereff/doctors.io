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
        return new TimeslotCollection(Timeslot::getAll());
    }

    public function store(StoreTimeslotRequest $request): TimeslotResource
    {
        $data = $request->validated();

        $timeslot = Timeslot::create($data);

        return new TimeslotResource($timeslot);
    }

    public function show(Timeslot $timeslot): TimeslotResource
    {
        return new TimeslotResource($timeslot);
    }

    public function update(UpdateTimeslotRequest $request, Timeslot $timeslot): TimeslotResource
    {
        $data = $request->validated();

        $timeslot->update($data);

        return new TimeslotResource($timeslot);
    }

    public function destroy(Timeslot $timeslot): void
    {
        $timeslot->delete();
    }
}
