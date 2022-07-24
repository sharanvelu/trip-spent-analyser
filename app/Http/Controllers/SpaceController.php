<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Requests\SpaceStoreRequest;
use App\Http\Requests\SpaceUpdateRequest;

class SpaceController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', Space::class);

        return view('app.spaces.create');
    }

    /**
     * @param SpaceStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(SpaceStoreRequest $request)
    {
        $this->authorize('create', Space::class);

        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $space = Space::create($validated);

        return redirect()
            ->route('spaces.show', $space)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Space $space)
    {
        $this->authorize('view', $space);

        $search = $request->get('search', '');

        $trips = $space->trips()
            ->search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.spaces.show', compact('space', 'trips', 'search'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, Space $space)
    {
        $this->authorize('update', $space);

        return view('app.spaces.edit', compact('space'));
    }

    /**
     * @param SpaceUpdateRequest $request
     * @param Space $space
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param Request $request
     * @param Space $space
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
