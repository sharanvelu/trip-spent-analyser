<div class="py-12 w-full">
    <div class="max-w-7xl mx-auto">
        <x-partials.card>
            <x-slot name="title">@lang('crud.expenses.index_title')</x-slot>

            <div class="mb-5 mt-4">
                <div class="flex flex-wrap justify-between">
                    <div class="md:w-1/2">
                        <form>
                            <div class="flex items-center w-full">
                                <x-inputs.text autocomplete="off" name="search"
                                               placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                ></x-inputs.text>

                                <div class="ml-1">
                                    <button class="button button-primary" type="submit">
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="md:w-1/2 text-right">
                        <a class="button button-primary" href="{{ route('expenses.split', ['space' => $space, 'trip' => $trip]) }}">
                            <i class="mr-1 icon ion-md-create"></i>
                            Split View
                        </a>
                        @can('create', App\Models\Expense::class)
                            <a class="button button-primary" href="{{ route('expenses.create', ['space' => $space, 'trip' => $trip]) }}">
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="block w-full overflow-auto scrolling-touch">
                <table class="w-full max-w-full mb-4 bg-transparent">
                    <thead class="text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            @lang('crud.expenses.inputs.trip_id')
                        </th>
                        <th class="px-4 py-3 text-left">
                            @lang('crud.expenses.inputs.user_id')
                        </th>
                        <th class="px-4 py-3 text-left">
                            @lang('crud.expenses.inputs.description')
                        </th>
                        <th class="px-4 py-3 text-left">
                            @lang('crud.expenses.inputs.type')
                        </th>
                        <th class="px-4 py-3 text-right">
                            @lang('crud.expenses.inputs.amount')
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-left">
                                {{ optional($expense->trip)->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ optional($expense->user)->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ $expense->description ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ EXPENSE_TYPES[$expense->type] ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{ $expense->amount ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center" style="width: 134px;">
                                <div aria-label="Row Actions" class="relative inline-flex align-middle" role="group">
                                    @can('update', $expense)
                                        <a class="mr-1" href="{{ route('expenses.edit', ['space' => $space, 'trip' => $trip, 'expense' => $expense]) }}">
                                            <button class="button" type="button">
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        </a>
                                    @endcan @can('view', $expense)
                                        <a href="{{ route('expenses.show', ['space' => $space, 'trip' => $trip, 'expense' => $expense]) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                    @endcan @can('delete', $expense)
                                        <form
                                            action="{{ route('expenses.destroy', ['space' => $space, 'trip' => $trip, 'expense' => $expense]) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button type="submit" class="button">
                                                <i class="icon ion-md-trash text-red-600"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="mt-10 px-4">
                                {!! $expenses->render() !!}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </x-partials.card>
    </div>
</div>
