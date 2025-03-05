{{--
    NOTE: we've used the match to define multiple versions of width class and height,
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
    $heightClass = match($height) {
        'xs' => 'h-[63px]',
        'sm' => 'h-[88px]',
        'md' => 'h-[134px]',
        'lg' => 'h-[206px]',
        'xl' => 'h-[420px]',
    };
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <label class="block font-medium text-sm text-neutral-800 dark:text-neutral-200" for="id_{{ $name }}">
        {{ $label }}
    </label>
    <textarea id="id_{{ $name }}" name="{{ $name }}"
        class="appearance-none block
            mt-1 w-full {{ $heightClass }}
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
            disabled:border-transparent
            disabled:opacity-100
            disabled:select-none
            {{ !$resizable || $readonly ? 'resize-none' : 'resize-y' }}"
            autofocus="autofocus"
            @required($required)
            @disabled($readonly)
        >
        {{ $value }}
    </textarea>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
