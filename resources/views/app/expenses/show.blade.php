<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.expenses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('trips.show', ['space' => $space, 'trip' => $trip]) }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                    @lang('crud.expenses.show_title')
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.trip_id')
                        </h5>
                        <span>{{ optional($expense->trip)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.user_id')
                        </h5>
                        <span>{{ optional($expense->user)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.description')
                        </h5>
                        <span>{{ $expense->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.type')
                        </h5>
                        <span>{{ $expense->type ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.amount')
                        </h5>
                        <span>{{ $expense->amount ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('trips.show', ['space' => $space, 'trip' => $trip]) }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        Back to Trip
                    </a>

                    @can('create', App\Models\Expense::class)
                    <a href="{{ route('expenses.create', ['space' => $space, 'trip' => $trip]) }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
