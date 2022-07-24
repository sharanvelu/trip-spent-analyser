<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.trips.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('spaces.show', ['space' => $space]) }}" class="mr-4">
                        <i class="mr-1 icon ion-md-arrow-back"></i>
                    </a>
                    @lang('crud.trips.show_title')
                </x-slot>

                <div class="mt-4 px-4 flex flex-wrap">
                    <div class="mb-4 md:w-6/12 lg:w-6/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.space_id')
                        </h5>
                        <span>{{ optional($trip->space)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4 md:w-6/12 lg:w-6/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.name')
                        </h5>
                        <span>{{ $trip->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4 md:w-6/12 lg:w-6/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.from_date')
                        </h5>
                        <span>{{ formatDate($trip->from_date) }}</span>
                    </div>
                    <div class="mb-4 md:w-6/12 lg:w-6/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.to_date')
                        </h5>
                        <span>{{ formatDate($trip->to_date) }}</span>
                    </div>
                    <div class="mb-4 lg:w-6/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.description')
                        </h5>
                        <span>{{ $trip->description ?? '-' }}</span>
                    </div>

                    @include('app.expenses.index')

                </div>

                <div class="mt-10">
                    <a href="{{ route('spaces.show', [$trip->space_id]) }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        Back to Space
                    </a>

                    @can('create', App\Models\Trip::class)
                    <a href="{{ route('trips.edit', ['space' => $space, 'trip' => $trip]) }}" class="button">
                        <i class="mr-1 icon ion-md-create"></i>
                        @lang('crud.common.edit')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
