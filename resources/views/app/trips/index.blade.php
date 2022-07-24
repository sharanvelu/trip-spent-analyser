<div class="mb-4">
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <x-partials.card>
                <x-slot name="title"> @lang('crud.trips.index_title') </x-slot>

                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        autocomplete="off"
                                        name="search"
                                        placeholder="{{ __('crud.common.search') }}"
                                        value="{{ $search ?? '' }}"
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
                            @can('create', App\Models\Trip::class)
                                <a class="button button-primary" href="{{ route('trips.create', ['space' => $space]) }}">
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
                                @lang('crud.trips.inputs.space_id')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.trips.inputs.name')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.trips.inputs.description')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.trips.inputs.from_date')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.trips.inputs.to_date')
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600">
                        @forelse($trips as $trip)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional($trip->space)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ formatDate($trip->from_date) ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ formatDate($trip->to_date) ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div aria-label="Row Actions" class="relative inline-flex align-middle" role="group">
                                        @can('update', $trip)
                                            <a href="{{ route('trips.edit', ['space' => $space, 'trip' => $trip]) }}" class="mr-1">
                                                <button class="button" type="button">
                                                    <i class="icon ion-md-create"></i>
                                                </button>
                                            </a>
                                        @endcan @can('view', $trip)
                                            <a class="mr-1" href="{{ route('trips.show', ['space' => $space, 'trip' => $trip]) }}">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan @can('delete', $trip)
                                            <form
                                                action="{{ route('trips.destroy', ['space' => $space, 'trip' => $trip]) }}"
                                                method="POST"
                                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                            >
                                                @csrf @method('DELETE')
                                                <button class="button" type="submit">
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
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</div>
