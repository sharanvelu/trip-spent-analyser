<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.trips.create_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('spaces.show', ['space' => $space]) }}" class="mr-4">
                        <i class="mr-1 icon ion-md-arrow-back"></i>
                    </a>
                    @lang('crud.trips.create_title')
                </x-slot>

                <x-form action="{{ route('trips.store', ['space' => $space]) }}" class="mt-4" method="POST">
                    @include('app.trips.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('spaces.show', ['space' => $space]) }}" class="button">
                            <i class="mr-1 icon ion-md-return-left text-primary"></i>
                            Back to Space
                        </a>

                        <button class="button button-primary float-right" type="submit">
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.create')
                        </button>
                    </div>
                </x-form>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
