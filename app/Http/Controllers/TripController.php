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
     * @param Request $request
     * @param Space $space
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Space $space)
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
     * @param Space $space
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Space $space)
    {
        $this->authorize('create', Trip::class);

        return view('app.trips.create', compact('space'));
    }

    /**
     * @param TripStoreRequest $request
     * @param Space $space
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(TripStoreRequest $request, Space $space)
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validated();
        $validated['created_by'] = auth()->id();
        $validated['space_id'] = $space->id;

        $trip = Trip::create($validated);

        return redirect()
            ->route('trips.show', $trip)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Space $space, Trip $trip)
    {
        $this->authorize('view', $trip);

        $search = $request->get('search', '');

        $expenses = $trip->expenses()
            ->search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.trips.show', compact('trip', 'space', 'expenses', 'search'));
    }

    /**
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Space $space, Trip $trip)
    {
        $this->authorize('update', $trip);

        $users = $trip->space->users()->get();

        return view('app.trips.edit', compact('trip', 'users', 'space'));
    }

    /**
     * @param TripUpdateRequest $request
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(TripUpdateRequest $request, Space $space, Trip $trip)
    {
        $this->authorize('update', $trip);

        $trip->users()->sync($request->users);
        $validated = $request->validated();

        $trip->update($validated);

        return redirect()
            ->route('spaces.show', ['space' => $space])
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Space $space, Trip $trip)
    {
        $this->authorize('delete', $trip);

        $trip->delete();

        return redirect()
            ->route('trips.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
