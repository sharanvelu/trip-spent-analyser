@php $editing = isset($expense) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.select name="trip_id" label="Trip" required>
            @php $selected = old('trip_id', ($editing ? $expense->trip_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Trip</option>
            @foreach($trips as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $expense->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $expense->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.text
            name="type"
            label="Type"
            value="{{ old('type', ($editing ? $expense->type : '')) }}"
            maxlength="255"
            placeholder="Type"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $expense->amount : '')) }}"
            min="1"
            max="255"
            step="1"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
