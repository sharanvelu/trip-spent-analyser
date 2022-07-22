<?php
namespace App\Http\Controllers\Api;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class TripUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Trip $trip)
    {
        $this->authorize('view', $trip);

        $search = $request->get('search', '');

        $users = $trip
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Trip $trip, User $user)
    {
        $this->authorize('update', $trip);

        $trip->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Trip $trip, User $user)
    {
        $this->authorize('update', $trip);

        $trip->users()->detach($user);

        return response()->noContent();
    }
}
