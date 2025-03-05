@php
    $widthClass = match($width) {
        'full' => 'w-full',
        'xs' => 'w-20',
        'sm' => 'w-32',
        'md' => 'w-64',
        'lg' => 'w-96',
        'xl' => 'w-[48rem]',
        '1/3' => 'w-1/3',
        '2/3' => 'w-2/3',
        '1/4' => 'w-1/4',
        '2/4' => 'w-2/4',
        '3/4' => 'w-3/4',
        '1/5' => 'w-1/5',
        '2/5' => 'w-2/5',
        '3/5' => 'w-3/5',
        '4/5' => 'w-4/5',
    };
    $selectedValue = array_key_exists($value, $options) ? $value : $defaultValue;
@endphp

<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <label class="block font-medium text-sm text-neutral-800 dark:text-neutral-200" for="id_{{ $name }}">
        {{ $label }}
    </label>
    <select id="id_{{ $name }}" name="{{ $name }}"
        class="appearance-none mt-1 block
            w-full
            bg-neutral-100 dark:bg-neutral-900
            text-neutral-900 dark:text-neutral-100
            placeholder-neutral-600 dark:placeholder-neutral-500
            @error($name)
                border-red-500
            @else
                border-neutral-300 dark:border-neutral-700
            @enderror
            focus:border-yellow-400 dark:focus:border-yellow-300
            focus:ring-yellow-400 dark:focus:ring-yellow-300
            rounded-md shadow-sm
            disabled:rounded-none disabled:shadow-none
            disabled:border-t-transparent disabled:border-x-transparent
            disabled:border-dashed
            disabled:bg-none
            disabled:opacity-100
            disabled:select-none"
            autofocus="autofocus"
            @required($required)
            @disabled($readonly)
        >
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" @selected($selectedValue == $key)>{{ $value }}</option>
        @endforeach
    </select>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
