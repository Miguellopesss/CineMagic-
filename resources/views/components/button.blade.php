{{--
    NOTE: we've used the match to define multiple versions of the button (by Type),
    to ensure that all specific color related classes are defined statically
    on the source code - this guarantees that the Tailwind builder
    detects the corresponding class.
    If we had used dynamically generated classes (e.g. "bg-{{ $color }}-800") then
    the builder would not detect concrete values.
    Check documentation about dynamic classes:
    https://tailwindcss.com/docs/content-configuration#dynamic-class-names
--}}
@php
    $colors = match($type) {
        'primary' => 'text-white dark:text-neutral-900
                        bg-blue-600 dark:bg-blue-400
                        hover:bg-blue-700 dark:hover:bg-blue-300
                        focus:bg-blue-700 dark:focus:bg-blue-300
                        active:bg-blue-800 dark:active:bg-blue-200 ',
        'secondary' => 'text-white dark:text-neutral-700
                        bg-neutral-500 dark:bg-neutral-400
                        hover:bg-neutral-600 dark:hover:bg-neutral-300
                        focus:bg-neutral-600 dark:focus:bg-neutral-300
                        active:bg-neutral-700 dark:active:bg-neutral-200',
        'success' => 'text-white dark:text-neutral-900
                        bg-green-700 dark:bg-green-500
                        hover:bg-green-800 dark:hover:bg-green-600
                        focus:bg-green-800 dark:focus:bg-green-600
                        active:bg-green-900 dark:active:bg-green-600',
        'danger' => 'text-white dark:text-neutral-900
                        bg-red-600 dark:bg-red-500
                        hover:bg-red-700 dark:hover:bg-red-600
                        focus:bg-red-700 dark:focus:bg-red-600
                        active:bg-red-800 dark:active:bg-red-600',
        'warning' => 'text-neutral-900 dark:text-neutral-200
                        bg-yellow-400
                        hover:bg-yellow-300 dark:hover:bg-yellow-500
                        focus:bg-yellow-300 dark:focus:bg-yellow-500
                        active:bg-yellow-300 dark:active:bg-yellow-500
                        focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800',
        'info' => 'text-neutral-900 dark:text-neutral-200
                        bg-cyan-400 dark:bg-cyan-600
                        hover:bg-cyan-300 dark:hover:bg-cyan-700
                        focus:bg-cyan-300 dark:focus:bg-cyan-700
                        active:bg-cyan-300 dark:active:bg-cyan-700',
        'light' => 'text-neutral-900 dark:text-neutral-200
                        bg-slate-50 dark:bg-slate-600
                        hover:bg-slate-200 dark:hover:bg-slate-700
                        focus:bg-slate-200 dark:focus:bg-slate-700
                        active:bg-slate-200 dark:active:bg-slate-700',
        'link' => 'text-blue-500
                        border-neutral-200',
        default => 'text-white dark:text-neutral-900
                        bg-neutral-800 dark:bg-neutral-200
                        hover:bg-neutral-900 dark:hover:bg-neutral-100
                        focus:bg-neutral-900 dark:focus:bg-neutral-100
                        active:bg-neutral-950 dark:active:bg-neutral-50
                        focus:ring-2 focus:ring-neutral-300 dark:focus:ring-neutral-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800',
    }
@endphp
<div {{ $attributes }}>
    @if ($element == 'a')
        <a href="{{ $href }}"
            class="px-4 py-2 inline-block border border-transparent rounded-full
                    font-medium text-sm tracking-widest
                    focus:outline-none focus:ring-2
                    focus:ring-neutral-500 dark:focus:ring-neutral-400
                    focus:ring-offset-2 transition ease-in-out duration-150 {{ $colors }}">
            {{ $text }}
        </a>
    @else
        <button type="{{ $element }}" {{ $buttonName ? "name='$buttonName'" : '' }}
            @if(($element == 'submit') && ($attributes->has('form')))
                {{ $attributes->merge(['form' => '#']) }}
            @endif
            class="px-4 py-2 inline-block border border-transparent rounded-full
                    font-medium text-sm tracking-widest
                    focus:outline-none focus:ring-2
                    focus:ring-neutral-500 dark:focus:ring-neutral-400
                    focus:ring-offset-2 transition ease-in-out duration-150 {{ $colors }}">
            {{ $text }}
        </button>
    @endif
</div>
