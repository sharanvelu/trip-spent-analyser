@php $editing = isset($trip) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="space_id" label="Space" required>
            @php $selected = old('space_id', ($editing ? $trip->space_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Space</option>
            @foreach($spaces as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $trip->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $trip->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.date
            name="from_date"
            label="From Date"
            value="{{ old('from_date', ($editing ? optional($trip->from_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.date
            name="to_date"
            label="To Date"
            value="{{ old('to_date', ($editing ? optional($trip->to_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    @if($editing)
    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.users.name')
        </h4>

        <div class="py-2">
            @foreach ($users as $user)
            <div>
                <x-inputs.checkbox
                    id="user{{ $user->id }}"
                    name="users[]"
                    label="{{ ucfirst($user->name) }}"
                    value="{{ $user->id }}"
                    :checked="isset($trip) ? $trip->users()->where('id', $user->id)->exists() : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
