<?php

namespace App\Http\Controllers\Api;

use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripCollection;

class SpaceTripsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Space $space)
    {
        $this->authorize('view', $space);

        $search = $request->get('search', '');

        $trips = $space
            ->trips()
            ->search($search)
            ->latest()
            ->paginate();

        return new TripCollection($trips);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Space $space)
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date'],
        ]);

        $trip = $space->trips()->create($validated);

        return new TripResource($trip);
    }
}
