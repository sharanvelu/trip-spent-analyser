<?php

namespace App\Http\Controllers\Api;

use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Http\Resources\SpaceCollection;
use App\Http\Requests\SpaceStoreRequest;
use App\Http\Requests\SpaceUpdateRequest;

class SpaceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Space::class);

        $search = $request->get('search', '');

        $spaces = Space::search($search)
            ->latest()
            ->paginate();

        return new SpaceCollection($spaces);
    }

    /**
     * @param \App\Http\Requests\SpaceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpaceStoreRequest $request)
    {
        $this->authorize('create', Space::class);

        $validated = $request->validated();

        $space = Space::create($validated);

        return new SpaceResource($space);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Space $space)
    {
        $this->authorize('view', $space);

        return new SpaceResource($space);
    }

    /**
     * @param \App\Http\Requests\SpaceUpdateRequest $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function update(SpaceUpdateRequest $request, Space $space)
    {
        $this->authorize('update', $space);

        $validated = $request->validated();

        $space->update($validated);

        return new SpaceResource($space);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Space $space)
    {
        $this->authorize('delete', $space);

        $space->delete();

        return response()->noContent();
    }
}
