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
    }
@endphp
<div {{ $attributes->merge(['class' => "$widthClass relative"]) }}>
    @if(!$search)
        <label class="block font-medium text-sm text-neutral-800 dark:text-neutral-200" for="id_{{ $name }}">
            {{ $label }}
        </label>
    @endif
    <div class="relative mt-1 flex items-center">
        <input id="id_{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}"
            class="appearance-none block
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
                rounded-md shadow-sm @if($search) pl-10 @endif
                disabled:rounded-none disabled:shadow-none
                disabled:border-t-transparent disabled:border-x-transparent
                disabled:border-dashed
                disabled:opacity-100
                disabled:select-none"
                autofocus="autofocus"
                @required($required)
                @disabled($readonly)
                placeholder="{{ $placeholder }}"
            >
        @if($search)
            <div class="absolute left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-neutral-600 dark:text-neutral-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
        @endif
    </div>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
