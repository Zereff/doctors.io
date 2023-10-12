<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvailabilityRequest;
use App\Http\Requests\UpdateAvailabilityRequest;
use App\Http\Resources\AvailabilityCollection;
use App\Http\Resources\AvailabilityResource;
use App\Models\Availability;

class AvailabilityController extends Controller
{
    public function index(): AvailabilityCollection
    {
        $this->authorize('viewAny', Availability::class);

        $user = \Auth::user();

        return new AvailabilityCollection(Availability::getAll($user));
    }

    public function store(StoreAvailabilityRequest $request): AvailabilityResource
    {
        $user = \Auth::user();
        $data = $request->validated();

        if ($user->isDoctor()) {
            $data['doctor_id'] = $user->userable_id;
        }

        $availability = Availability::create($data);

        return new AvailabilityResource($availability);
    }

    public function show(Availability $availability): AvailabilityResource
    {
        $this->authorize('view', $availability);

        return new AvailabilityResource($availability);
    }

    public function update(UpdateAvailabilityRequest $request, Availability $availability): AvailabilityResource
    {
        $data = $request->validated();

        $availability->update($data);

        return new AvailabilityResource($availability);
    }

    public function destroy(Availability $availability): ?bool
    {
        $this->authorize('delete', $availability);

        return $availability->delete();
    }
}
