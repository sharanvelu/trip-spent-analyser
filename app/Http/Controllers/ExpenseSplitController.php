<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseSplitDataTable;
use App\Models\Space;
use App\Models\Trip;
use Illuminate\Http\Request;

class ExpenseSplitController extends Controller
{
    /**
     * @param ExpenseSplitDataTable $expenseSplitDataTable
     * @param Space $space
     * @param Trip $trip
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(ExpenseSplitDataTable $expenseSplitDataTable, Space $space, Trip $trip)
    {
        return $expenseSplitDataTable->render('app.expense_split.index', compact('space', 'trip'));
    }
}
