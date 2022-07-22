<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use App\Models\Space;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.trips.index', compact('trips', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Trip::class);

        $spaces = Space::pluck('name', 'id');

        return view('app.trips.create', compact('spaces'));
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

        return redirect()
            ->route('trips.edit', $trip)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Trip $trip)
    {
        $this->authorize('view', $trip);

        return view('app.trips.show', compact('trip'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Trip $trip)
    {
        $this->authorize('update', $trip);

        $spaces = Space::pluck('name', 'id');

        $users = User::get();

        return view('app.trips.edit', compact('trip', 'spaces', 'users'));
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
        $trip->users()->sync($request->users);

        $trip->update($validated);

        return redirect()
            ->route('trips.edit', $trip)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('trips.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
