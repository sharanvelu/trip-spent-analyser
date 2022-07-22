<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.spaces.index', compact('spaces', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Space::class);

        return view('app.spaces.create');
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

        return redirect()
            ->route('spaces.edit', $space)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Space $space)
    {
        $this->authorize('view', $space);

        return view('app.spaces.show', compact('space'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space $space
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Space $space)
    {
        $this->authorize('update', $space);

        return view('app.spaces.edit', compact('space'));
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

        return redirect()
            ->route('spaces.edit', $space)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('spaces.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
