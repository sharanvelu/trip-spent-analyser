<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.spaces.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title"> @lang('crud.spaces.index_title') </x-slot>

                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text autocomplete="off" name="search"
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
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    {!! $dataTable->table(['width' => '100%']) !!}
                </div>
            </x-partials.card>
        </div>
    </div>

    @push('css_lib')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    @endpush

    @push('scripts_lib')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    @endpush

    @push('scripts')
        {!! $dataTable->scripts() !!}
    @endpush
</x-app-layout>
