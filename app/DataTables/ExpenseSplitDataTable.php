<?php

namespace App\DataTables;

use App\Models\Expense;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ExpenseSplitDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('spent', function ($expense) {
                return "($expense->spent_count) " . $expense->spent;
            })
            ->editColumn('share', function ($expense) {
                return number_format($expense->share, 2);
            })
            ->editColumn('balance', function ($expense) {
                return number_format($expense->balance, 2);
            })
//            ->addColumn('action', 'app.expense_split.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return QueryBuilder
     */
    public function query(User $model): QueryBuilder
    {
        $tripId = request()->route()->originalParameter('trip');

        $trip = Trip::find($tripId);
        $tripUserIds = $trip->users()->pluck('id');

        $tripTotalSpent = Expense::query()->where('trip_id', $tripId)->sum('amount');
        $TripUsersCount = $tripUserIds->count();

        return $model->newQuery()
            ->select([
                'users.name',
                'users.email',
                'expense.spent_count',
                DB::raw('(' . $tripTotalSpent . ') as total_expense'),
                DB::raw('coalesce(expense.spent, 0) as spent'),
                DB::raw('(' . $tripTotalSpent . ' / ' . $TripUsersCount . ') as share'),
                DB::raw('((' . $tripTotalSpent . ' /' . $TripUsersCount . ') - coalesce(expense.spent, 0)) as balance'),
            ])
            ->leftJoin(DB::raw('(select sum(expenses.amount) as spent, count(*) as spent_count, user_id from expenses where expenses.trip_id = ' . $tripId . ' group by user_id) expense'), 'users.id', '=', 'expense.user_id')
            ->whereIn('users.id', $tripUserIds);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('expense_split_table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('email'),
            Column::make('total_expense'),
            Column::make('spent'),
            Column::make('share'),
            Column::make('balance'),
//            Column::computed('action')
//                ->exportable(false)
//                ->printable(false)
//                ->width(60)
//                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ExpenseSplit_' . date('YmdHis');
    }
}
