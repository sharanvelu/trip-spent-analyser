<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceCollection;

class UserSpacesController extends Controller
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

        $spaces = $user
            ->spaces()
            ->search($search)
            ->latest()
            ->paginate();

        return new SpaceCollection($spaces);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Space $space)
    {
        $this->authorize('update', $user);

        $user->spaces()->syncWithoutDetaching([$space->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Space $space)
    {
        $this->authorize('update', $user);

        $user->spaces()->detach($space);

        return response()->noContent();
    }
}
