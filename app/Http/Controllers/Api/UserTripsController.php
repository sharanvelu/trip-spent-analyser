<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripCollection;

class UserTripsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $trips = $user
            ->trips2()
            ->search($search)
            ->latest()
            ->paginate();

        return new TripCollection($trips);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Trip $trip)
    {
        $this->authorize('update', $user);

        $user->trips2()->syncWithoutDetaching([$trip->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Trip $trip)
    {
        $this->authorize('update', $user);

        $user->trips2()->detach($trip);

        return response()->noContent();
    }
}
