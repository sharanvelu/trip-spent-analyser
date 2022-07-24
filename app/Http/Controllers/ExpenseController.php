<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Trip;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class ExpenseController extends Controller
{
    /**
     * @param Request $request
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Space $space, Trip $trip)
    {
        $this->authorize('view-any', Expense::class);

        $search = $request->get('search', '');

        $expenses = Expense::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expenses.index', compact('expenses', 'search'));
    }

    /**
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Space $space, Trip $trip)
    {
        $this->authorize('create', Expense::class);

        $users = $trip->users()->pluck('name', 'id');

        return view('app.expenses.create', compact('users', 'space', 'trip'));
    }

    /**
     * @param ExpenseStoreRequest $request
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ExpenseStoreRequest $request, Space $space, Trip $trip)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validated();
        $validated['trip_id'] = $trip->id;

        Expense::create($validated);

        return redirect()
            ->route('trips.show', ['space' => $space, 'trip' => $trip])
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @param Trip $trip
     * @param Expense $expense
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Space $space, Trip $trip, Expense $expense)
    {
        $this->authorize('view', $expense);

        return view('app.expenses.show', compact('expense', 'space', 'trip'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @param Trip $trip
     * @param Expense $expense
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, Space $space, Trip $trip, Expense $expense)
    {
        $this->authorize('update', $expense);

        $users = $trip->users()->pluck('name', 'id');

        return view('app.expenses.edit', compact('expense', 'users', 'space', 'trip'));
    }

    /**
     * @param ExpenseUpdateRequest $request
     * @param Space $space
     * @param Trip $trip
     * @param Expense $expense
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ExpenseUpdateRequest $request, Space $space, Trip $trip, Expense $expense)
    {
        $this->authorize('update', $expense);

        $validated = $request->validated();

        $expense->update($validated);

        return redirect()
            ->route('trips.show', ['space' => $space, 'trip' => $trip])
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param Request $request
     * @param Space $space
     * @param Trip $trip
     * @param Expense $expense
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Space $space, Trip $trip, Expense $expense)
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
