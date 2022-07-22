<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class SpaceUsersController extends Controller
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

        $users = $space
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Space $space, User $user)
    {
        $this->authorize('update', $space);

        $space->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Space $space, User $user)
    {
        $this->authorize('update', $space);

        $space->users()->detach($user);

        return response()->noContent();
    }
}
