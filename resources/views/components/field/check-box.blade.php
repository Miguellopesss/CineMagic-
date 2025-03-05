{{--
    NOTE: we've used the match to define multiple versions of width class,
    to ensure that all specific width related classes are defined statically
    on the source code - this guarantees that the Tailwind builder
    detects the corresponding class.
    If we had used dynamically generated classes (e.g. "w-{{ $width }}") then
    the builder would not detect concrete values.
    Check documentation about dynamic classes:
    https://tailwindcss.com/docs/content-configuration#dynamic-class-names
--}}
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
@endphp

<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <label class="block font-medium text-sm text-neutral-800 dark:text-neutral-200" for="id_{{ $name }}">
        {{ $label }}
    </label>
    <div class="flex">
        <input name="{{ $name }}" type="hidden" value="0">
        <input id="id_{{ $name }}" name="{{ $name }}" type="checkbox"
            {{ $value ? 'checked' : '' }}
            value="1"
            class="appearance-none mt-0.5 w-6 h-6
                bg-neutral-100 dark:bg-neutral-900
                text-neutral-900 dark:text-neutral-100
                rounded-md
                border-neutral-300 dark:border-neutral-700
                focus:border-yellow-400 dark:focus:border-yellow-300
                focus:ring-yellow-400 dark:focus:ring-yellow-300
                shadow-sm
                disabled:text-neutral-500
                disabled:opacity-100
                disabled:select-none
                checked:bg-yellow-500
                checked:hover:bg-yellow-400
                hover:cursor-pointer
                checked:border-transparent"
                autofocus="autofocus"
                @required($required)
                @disabled($readonly)
            >
        <style>
            #id_{{ $name }}:checked + label::after {
                content: '\2714';
                display: inline-block;
                margin-left: 0.25rem;
                font-size: 1rem;
                color: #fff;
            }
        </style>
    </div>
    @error($name)
        <div class="text-sm text-red-500 -mt-5">
            {{ $message }}
        </div>
    @enderror
</div>
