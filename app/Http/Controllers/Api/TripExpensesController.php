<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class TripExpensesController extends Controller
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

        $expenses = $trip
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Trip $trip)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'description' => ['nullable', 'max:255', 'string'],
            'type' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        $expense = $trip->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
