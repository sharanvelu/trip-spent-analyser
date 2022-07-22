<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripCollection;
use App\Http\Requests\TripStoreRequest;
use App\Http\Requests\TripUpdateRequest;

class TripController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Trip::class);

        $search = $request->get('search', '');

        $trips = Trip::search($search)
            ->latest()
            ->paginate();

        return new TripCollection($trips);
    }

    /**
     * @param \App\Http\Requests\TripStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TripStoreRequest $request)
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validated();

        $trip = Trip::create($validated);

        return new TripResource($trip);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Trip $trip)
    {
        $this->authorize('view', $trip);

        return new TripResource($trip);
    }

    /**
     * @param \App\Http\Requests\TripUpdateRequest $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function update(TripUpdateRequest $request, Trip $trip)
    {
        $this->authorize('update', $trip);

        $validated = $request->validated();

        $trip->update($validated);

        return new TripResource($trip);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Trip $trip)
    {
        $this->authorize('delete', $trip);

        $trip->delete();

        return response()->noContent();
    }
}
